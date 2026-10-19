<?php

declare(strict_types=1);

class AnelHUT extends IPSModuleStrict
{
    private const SEND_PORT = 75;

    public function Create(): void
    {
        //Never delete this line!
        parent::Create();

        $this->ConnectParent('{82347F20-F541-41E1-AC5B-A636FD3AE2D8}');
        $this->RegisterPropertyString('IPAddress', '');
        $this->RegisterPropertyString('Username', '');
        $this->RegisterPropertyString('Password', '');
        $this->RegisterPropertyBoolean('IOs', false);
        $this->RegisterPropertyBoolean('DeviceTemperature', false);
    }

    public function Destroy(): void
    {
        //Never delete this line!
        parent::Destroy();
    }

    public function ApplyChanges(): void
    {
        //Never delete this line!
        parent::ApplyChanges();
        $this->SetReceiveDataFilter('.*' . $this->ReadPropertyString('IPAddress') . '.*');

        if ($this->ReadPropertyBoolean('DeviceTemperature')) {
            $this->maintainTemperature('DeviceTemperature', $this->Translate('Temperature from Device'));
        }
    }

    public function ReceiveData(string $JSONString): string
    {
        $data = json_decode($JSONString);
        if (!is_object($data) || !isset($data->Buffer)) {
            return '';
        }
        //IPSModuleStrict liefert die Socket-Daten HEX-kodiert, das Gerät sendet ISO-8859-1
        $raw = ctype_xdigit($data->Buffer) && strlen($data->Buffer) % 2 === 0 ? hex2bin($data->Buffer) : $data->Buffer;
        $buffer = mb_convert_encoding($raw, 'UTF-8', 'ISO-8859-1');
        $result = explode(':', $buffer);

        $this->SendDebug(__FUNCTION__, $buffer, 0);

        $indexRelais = 5;
        $indexIOs = 15;
        for ($i = 1; $i <= 8; $i++) {
            //Relais
            $indexRelais++;
            if (isset($result[$indexRelais])) {
                $tmpValue = explode(',', $result[$indexRelais]);
                if (count($tmpValue) >= 2) {
                    $this->MaintainVariable('Relay' . $i, $tmpValue[0], VARIABLETYPE_BOOLEAN, ['PRESENTATION' => VARIABLE_PRESENTATION_SWITCH], 0, true);
                    $this->EnableAction('Relay' . $i);
                    $this->SetValue('Relay' . $i, (bool) $tmpValue[1]);
                }
            }

            //IOs
            $indexIOs++;
            if ($this->ReadPropertyBoolean('IOs') && isset($result[$indexIOs])) {
                $tmpValue = explode(',', $result[$indexIOs]);
                if (count($tmpValue) >= 3) {
                    //Ein IO ist als Ausgang schaltbar (Schalter), als Eingang nur eine Anzeige
                    $isOutput = $tmpValue[1] == 0;
                    $this->MaintainVariable('IO' . $i, $tmpValue[0], VARIABLETYPE_BOOLEAN, $this->getIOPresentation($isOutput), 0, true);
                    if ($isOutput) {
                        $this->EnableAction('IO' . $i);
                    } else {
                        $this->DisableAction('IO' . $i);
                    }
                    $this->SetValue('IO' . $i, (bool) $tmpValue[2]);
                }
            }
        }

        //Index 24 Temperatur
        if ($this->ReadPropertyBoolean('DeviceTemperature') && isset($result[24])) {
            $this->SetValue('DeviceTemperature', floatval(str_replace('°C', '', $result[24])));
        }

        //Index 26 (Gerätetyp) und 27 (Power Metering) sind nicht bei jeder Firmware vorhanden
        if (array_key_exists(27, $result)) {
            //p = Power Metering vorhanden, Sensor ab Index 34; n = nicht vorhanden, Sensor ab Index 28
            $SensorIndex = match ($result[27]) {
                'p'     => 34,
                'n'     => 28,
                default => 0
            };

            //Sensor yes or no
            if ($SensorIndex > 0 && isset($result[$SensorIndex + 3]) && $result[$SensorIndex] == 's') {
                $this->maintainTemperature('SensorTemperature', $this->Translate('Sensor Temperature'));
                $this->MaintainVariable('SensorHumidity', $this->Translate('Sensor Humidity'), VARIABLETYPE_FLOAT, ['PRESENTATION' => VARIABLE_PRESENTATION_VALUE_PRESENTATION, 'SUFFIX' => ' %', 'DIGITS' => 1], 0, true);
                $this->MaintainVariable('SensorBrightness', $this->Translate('Sensor Brightness'), VARIABLETYPE_INTEGER, ['PRESENTATION' => VARIABLE_PRESENTATION_VALUE_PRESENTATION, 'SUFFIX' => ' lx'], 0, true);

                $this->SetValue('SensorTemperature', floatval($result[$SensorIndex + 1]));
                $this->SetValue('SensorHumidity', floatval($result[$SensorIndex + 2]));
                $this->SetValue('SensorBrightness', intval($result[$SensorIndex + 3]));
            }
        }
        return '';
    }

    public function GetConfigurationForParent(): string
    {
        //Der UDP Socket sendet nur mit gesetztem Host. Die ClientIP jeder Nachricht überschreibt ihn.
        $Config['Host'] = $this->ReadPropertyString('IPAddress');
        $Config['BindPort'] = 77;
        $Config['Port'] = self::SEND_PORT;
        $Config['BindIP'] = '0.0.0.0';
        $Config['EnableBroadcast'] = 0;
        $Config['EnableReuseAddress'] = 1;
        return json_encode($Config);
    }

    public function RequestAction(string $Ident, mixed $Value): void
    {
        if (str_starts_with($Ident, 'Relay')) {
            $this->setSwitch('Sw', (int) substr($Ident, 5), (bool) $Value);
        } elseif (str_starts_with($Ident, 'IO')) {
            $this->setSwitch('IO', (int) substr($Ident, 2), (bool) $Value);
        }
    }

    private function maintainTemperature(string $ident, string $name): void
    {
        $this->MaintainVariable($ident, $name, VARIABLETYPE_FLOAT, ['PRESENTATION' => VARIABLE_PRESENTATION_VALUE_PRESENTATION, 'SUFFIX' => ' °C', 'DIGITS' => 1], 0, true);
    }

    private function getIOPresentation(bool $isOutput): array
    {
        if ($isOutput) {
            return ['PRESENTATION' => VARIABLE_PRESENTATION_SWITCH];
        }
        $options = [];
        foreach ([false => 'Off', true => 'On'] as $value => $caption) {
            $options[] = [
                'Value'              => (bool) $value,
                'Caption'            => $this->Translate($caption),
                'IconActive'         => false,
                'IconValue'          => '',
                'ColorActive'        => false,
                'ColorValue'         => -1,
                'ContentColorActive' => false,
                'ContentColorValue'  => -1
            ];
        }
        return ['PRESENTATION' => VARIABLE_PRESENTATION_VALUE_PRESENTATION, 'OPTIONS' => json_encode($options)];
    }

    private function Send(string $buffer): void
    {
        //Der Buffer enthält die Zugangsdaten und kommt deshalb nicht ins Debug
        $this->SendDebug(__FUNCTION__, 'Send command to ' . $this->ReadPropertyString('IPAddress'), 0);
        $JSON = json_encode(['DataID' => '{8E4D9B23-E0F2-1E05-41D8-C21EA53B8706}', 'ClientIP' => $this->ReadPropertyString('IPAddress'), 'ClientPort' => self::SEND_PORT, 'Buffer' => bin2hex($buffer), 'Broadcast' => false]);
        $this->SendDataToParent($JSON);
    }

    private function setSwitch(string $prefix, int $number, bool $value): void
    {
        $payload = $prefix . ($value ? '_on' : '_off') . $number . $this->ReadPropertyString('Username') . $this->ReadPropertyString('Password');
        $this->Send($payload);
    }
}
