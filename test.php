
<?php


class SolaXCloudUserMonitoringAPI {

    public $json;
    public $jsonDecoded;

    public $success;
    public $exception;
    
    public $resultInverterSN;
    public $resultSn;
    public $resultAcpower;
    public $resultYieldtoday;
    public $resultYieldtotal;
    public $resultFeedinpower;
    public $resultFeedinenergy;
    public $resultConsumeenergy;
    public $resultFeedinpowerM2;
    public $resultSoc;
    public $resultPeps1;
    public $resultPeps2;
    public $resultPeps3;
    public $resultInverterType;
    public $resultInverterStatus;
    public $resultUploadTime;
    public $resultBatPower;
    public $resultPowerdc1;
    public $resultPowerdc2;
    public $resultPowerdc3;
    public $resultPowerdc4;
    public $resultBatStatus;

    public function SolaXCloudUserMonitoringAPI (){
        $this->loadJson();
        $this->decodeJson();
        $this->setJsonValues();

    }

    public function loadJson(){
        $this->$json = file_get_contents('https://qhome-ess-g3.q-cells.eu/proxyApp/proxy/api/getRealtimeInfo.do?tokenId=20220713034306409515821&sn=SW5QA9JKJR');
    }

    public function decodeJson(){
        $this->jsonDecoded = json_decode($this->$json, false, 5,0);
    }

    public function setJsonValues(){

        $this->success = $this->jsonDecoded->{'success'};
        $this->exception = $this->jsonDecoded->{'exception'};

        $this->resultInverterSN = $this->jsonDecoded->{'result'}->{'inverterSN'};
        $this->resultSn = $this->jsonDecoded->{'result'}->{'sn'};
        $this->resultAcpower = $this->jsonDecoded->{'result'}->{'acpower'};
        $this->resultYieldtoday = $this->jsonDecoded->{'result'}->{'yieldtoday'};
        $this->resultYieldtotal = $this->jsonDecoded->{'result'}->{'yieldtotal'};
        $this->resultFeedinpower = $this->jsonDecoded->{'result'}->{'feedinpower'};
        $this->resultFeedinenergy = $this->jsonDecoded->{'result'}->{'feedinenergy'};
        $this->resultConsumeenergy = $this->jsonDecoded->{'result'}->{'consumeenergy'};
        $this->resultFeedinpowerM2 = $this->jsonDecoded->{'result'}->{'feedinpowerM2'};
        $this->resultSoc = $this->jsonDecoded->{'result'}->{'soc'};
        $this->resultPeps1 = $this->jsonDecoded->{'result'}->{'peps1'};
        $this->resultPeps2 = $this->jsonDecoded->{'result'}->{'peps2'};
        $this->resultPeps3 = $this->jsonDecoded->{'result'}->{'peps3'};
        $this->resultInverterType = $this->jsonDecoded->{'result'}->{'inverterType'};
        $this->resultInverterStatus = $this->jsonDecoded->{'result'}->{'inverterStatus'};
        $this->resultUploadTime = $this->jsonDecoded->{'result'}->{'uploadTime'};
        $this->resultBatPower = $this->jsonDecoded->{'result'}->{'batPower'};
        $this->resultPowerdc1 = $this->jsonDecoded->{'result'}->{'powerdc1'};
        $this->resultPowerdc2 = $this->jsonDecoded->{'result'}->{'powerdc2'};
        $this->resultPowerdc3 = $this->jsonDecoded->{'result'}->{'powerdc3'};
        $this->resultPowerdc4 = $this->jsonDecoded->{'result'}->{'powerdc4'};
        $this->resultBatStatus = $this->jsonDecoded->{'result'}->{'batStatus'};

    }

    public function getApiSuccess(){
        if($this->success == 1)$result = true;
        else $result = false;

        return $result;
    }
    
    public function getPvPowerWatt(){
        
        $value = 0;
        if($this->resultPowerdc1>0) $value = $value + $this->resultPowerdc1;
        if($this->resultPowerdc2>0) $value = $value + $this->resultPowerdc2;
        if($this->resultPowerdc3>0) $value = $value + $this->resultPowerdc3;
        if($this->resultPowerdc4>0) $value = $value + $this->resultPowerdc4;
        
        return $value + 0;  
    }
    
    public function getFeedinPowerWatt(){
        return $this->resultFeedinpower;
    }

    public function getSocPercent(){
        return $this->resultSoc;
    }

    public function getAcPowerWatt(){
        return $this->resultAcpower;
    }

    public function getUsedPowerWatt(){
        
        $watt = $this->getAcPowerWatt();

        if($this->getFeedinPowerWatt() < 0) $watt = $watt + (-1 * $this->getFeedinPowerWatt());
        
        return $watt;
    }


    public function printJsonValues(){

        echo "success: ".$this->success."<br/>";
        echo "exception: ".$this->exception."<br/>";
        echo "resultInverterSN: ".$this->resultInverterSN."<br/>";
        echo "resultSn: ".$this->resultSn."<br/>";
        echo "resultAcpower: ".$this->resultAcpower."<br/>";
        echo "resultYieldtoday: ".$this->resultYieldtoday."<br/>";
        echo "resultYieldtotal: ".$this->resultYieldtotal."<br/>";
        echo "resultFeedinpower: ".$this->resultFeedinpower."<br/>";
        echo "resultFeedinenergy: ".$this->resultFeedinenergy."<br/>";
        echo "resultConsumeenergy: ".$this->resultConsumeenergy."<br/>";
        echo "resultFeedinpowerM2: ".$this->resultFeedinpowerM2."<br/>";
        echo "resultSoc: ".$this->resultSoc."<br/>";
        echo "resultPeps1: ".$this->resultPeps1."<br/>";
        echo "resultPeps2: ".$this->resultPeps2."<br/>";
        echo "resultPeps3: ".$this->resultPeps3."<br/>";
        echo "resultInverterType: ".$this->resultInverterType."<br/>";
        echo "resultInverterStatus: ".$this->resultInverterStatus."<br/>";
        echo "resultUploadTime: ".$this->resultUploadTime."<br/>";
        echo "resultBatPower: ".$this->resultBatPower."<br/>";
        echo "resultPowerdc1: ".$this->resultPowerdc1."<br/>";
        echo "resultPowerdc2: ".$this->resultPowerdc2."<br/>";
        echo "resultPowerdc3: ".$this->resultPowerdc3."<br/>";
        echo "resultPowerdc4: ".$this->resultPowerdc4."<br/>";
        echo "resultBatStatus: ".$this->resultBatStatus."<br/>";

    }

}


class GoEChargerAPIV2 {

    private $wallboxApiUrl;

    private $wallboxID;
    private $wallboxToken;

    //public $fb					;	// R					int						Status					Relay Feedback
    //public $rst					;	// W					any						Other					Ladestation neustarten
    public $alw					;	// R					bool					Status					Darf das Auto derzeit laden?
    public $acu					;	// R					int						Status					Mit wie vielen Ampere darf das Auto derzeit laden?
    public $adi					;	// R					bool					Status					Wird der 16A Adapter benutzt? Limitiert den Ladestrom auf 16A
    public $dwo					;	// R/W					optional<double>		Config					Lade Energy Limit, gemessen in Wh, null bedeutet deaktiviert, nicht mit der Next-Trip Energie zu verwechseln
    //public $tpa					;	// R					float					Status					30 Sekunden Gesamtleistungsdurchschnitt (wird für genauere next-trip vorhersagen berechnet)
    public $sse					;	// R					string					Constant				serial number
    //public $eto					;	// R					uint64					Status					energy_total, measured in Wh
    //public $wifis				;	// R/W					array					Config					WiFi Konfiguration mit SSID und Passwort; Wenn man nur den zweiten Eintrag ändern möchte, einfach das erste Objekt leer lassen: [{}, {"ssid":"","key":""}]
    //public $delw				;	// W					uint8					Other					set this to 0-9 to delete sta config (erases ssid, key, ...)
    //public $scan				;	// R					array					Status					wifi scan result (encryptionType: OPEN=0, WEP=1, WPA_PSK=2, WPA2_PSK=3, WPA_WPA2_PSK=4, WPA2_ENTERPRISE=5, WPA3_PSK=6, WPA2_WPA3_PSK=7)
    //public $scaa				;	// R					milliseconds			Status					wifi scan age
    //public $wst					;	// R					uint8					Status					WiFi STA status (IDLE_STATUS=0, NO_SSID_AVAIL=1, SCAN_COMPLETED=2, CONNECTED=3, CONNECT_FAILED=4, CONNECTION_LOST=5, DISCONNECTED=6, CONNECTING=8, DISCONNECTING=9, NO_SHIELD=10 (for compatibility with WiFi Shield library))
    //public $wsc					;	// R					uint8					Status					WiFi STA error count
    //public $wsm					;	// R					string					Status					WiFi STA error message
    //public $wsms				;	// R					uint8					Status					WiFi state machine state (None=0, Scanning=1, Connecting=2, Connected=3)
    //public $ccw					;	// R					optional<object>		Status					Currently connected WiFi
    public $ccwSsid 			;
    //public $wfb					;	// R					array					Status					WiFi failed mac addresses
    //public $wcb					;	// R					string					Status					WiFi current mac address
    //public $wpb					;	// R					array					Status					WiFi planned mac addresses
    //public $nif					;	// R					string					Status					Default route
    //public $dns					;	// R					object					Status					DNS server
    //public $host				;	// R					optional<string>		Status					hostname used on STA interface
    public $rssi				;	// R					optional<int8>			Status					RSSI signal strength
    //public $tse					;	// R/W					bool					Config					time server enabled (NTP)
    //public $tsss				;	// R					uint8					Config					time server sync status (RESET=0, COMPLETED=1, IN_PROGRESS=2)
    //public $tof					;	// R/W					minutes					Config					timezone offset in minutes
    //public $tds					;	// R/W					uint8					Config					timezone daylight saving mode, None=0, EuropeanSummerTime=1, UsDaylightTime=2
    //public $utc					;	// R/W					string					Status					utc time
    //public $loc					;	// R					string					Status					local time
    //public $led					;	// R					object					Status					internal infos about currently running led animation
    //public $lbr					;	// R/W					uint8					Config					led_bright, 0-255
    //public $lmo					;	// R/W					uint8					Config					logic mode (Default=3, Awattar=4, AutomaticStop=5)
    public $ama					;	// R/W					uint8					Config					ampere_max limit
    //public $clp					;	// R/W					array					Config					current limit presets, max. 5 entries
    //public $bac					;	// R/W					bool					Config					Button allow Current change
    //public $sdp					;	// R/W					bool					Config					Button Allow Force change
    //public $lbp					;	// R					milliseconds			Status					lastButtonPress in milliseconds
    public $amp					;	// R/W					uint8					Config					requestedCurrent in Ampere, used for display on LED ring and logic calculations
    public $fna					;	// R/W					string					Config					friendlyName
    //public $cid					;	// R/W					string					Config					color_idle, format: #RRGGBB
    //public $cwc					;	// R/W					string					Config					color_waitcar, format: #RRGGBB
    //public $cch					;	// R/W					string					Config					color_charging, format: #RRGGBB
    //public $cfi					;	// R/W					string					Config					color_finished, format: #RRGGBB
    //public $ust					;	// R/W					uint8					Config					unlock_setting (Normal=0, AutoUnlock=1, AlwaysLock=2)
    //public $lck					;	// R					uint8					Status					Effective lock setting, as sent to Charge Ctrl (Normal=0, AutoUnlock=1, AlwaysLock=2, ForceUnlock=3)
    //public $sch_week			;	// R/W					object					Config					scheduler_weekday, control enum values: Disabled=0, Inside=1, Outside=2
    //public $sch_satur			;	// R/W					object					Config					scheduler_saturday, control enum values: Disabled=0, Inside=1, Outside=2
    //public $sch_sund			;	// R/W					object					Config					scheduler_sunday, control enum values: Disabled=0, Inside=1, Outside=2
    //public $nmo					;	// R/W					bool					Config					norway_mode / ground check enabled when norway mode is disabled (inverted)
    //public $fsp					;	// R/W					bool					Status					force_single_phase (shows if currently single phase charge is enforced
    //public $lrn					;	// W					uint8					Other					set this to 0-9 to learn last read card id
    //public $del					;	// W					uint8					Other					set this to 0-9 to clear card (erases card name, energy and rfid id)
    //public $acs					;	// R/W					uint8					Config					access_control user setting (Open=0, Wait=1)
    public $frc					;	// R/W					uint8					Config					forceState (Neutral=0, Off=1, On=2)
    //public $rbc					;	// R					uint32					Status					reboot_counter
    //public $rbt					;	// R					milliseconds			Status					time since boot in milliseconds
    public $car					;	// R					optional<uint8>			Status					carState, null if internal error (Unknown/Error=0, Idle=1, Charging=2, WaitCar=3, Complete=4, Error=5)
    public $err					;	// R					optional<uint8>			Status					error, null if internal error (None = 0, FiAc = 1, FiDc = 2, Phase = 3, Overvolt = 4, Overamp = 5, Diode = 6, PpInvalid = 7, GndInvalid = 8, ContactorStuck = 9, ContactorMiss = 10, FiUnknown = 11, Unknown = 12, Overtemp = 13, NoComm = 14, StatusLockStuckOpen = 15, StatusLockStuckLocked = 16, Reserved20 = 20, Reserved21 = 21, Reserved22 = 22, Reserved23 = 23, Reserved24 = 24)
    public $cbl					;	// R					optional<int>			Status					cable_current_limit in A
    //public $pha					;	// R					optional<array>			Status					phases
    //public $wh					;	// R					double					Status					energy in Wh since car connected
    //public $trx					;	// R/W					optional<uint8>			Status					transaction, null when no transaction, 0 when without card, otherwise cardIndex + 1 (1: 0. card, 2: 1. card, ...)
    //public $fwv					;	// R					string					Constant				FW_VERSION
    //public $ccu					;	// R					optional<object>		Status					charge controller update progress (null if no update is in progress)
    //public $oem					;	// R					string					Constant				OEM manufacturer
    //public $typ					;	// R					string					Constant				Devicetype
    //public $fwc					;	// R					string					Constant				firmware from CarControl
    //public $ccrv				;	// R					string					Constant				chargectrl recommended version
    //public $lse					;	// R/W					bool					Config					led_save_energy
    //public $cdi					;	// R					object					Status					charging duration info (null=no charging in progress, type=0 counter going up, type=1 duration in ms)
    public $cdiType				;
    public $cdiValue			;
    public $lccfi				;	// R					optional<milliseconds>	Status					lastCarStateChangedFromIdle (in ms)
    public $lccfc				;	// R					optional<milliseconds>	Status					lastCarStateChangedFromCharging (in ms)
    public $lcctc				;	// R					optional<milliseconds>	Status					lastCarStateChangedToCharging (in ms)
    //public $tma					;	// R					array					Status					temperature sensors
    public $tma0                ;
    public $tma1                ;
    //public $amt					;	// R					int						Status					temperatureCurrentLimit
    public $nrg					;	// R					array					Status					energy array, U (L1, L2, L3, N), I (L1, L2, L3), P (L1, L2, L3, N, Total), pf (L1, L2, L3, N)
    public $modelStatus			;	// R					uint8					Status					Reason why we allow charging or not right now (NotChargingBecauseNoChargeCtrlData=0, NotChargingBecauseOvertemperature=1, NotChargingBecauseAccessControlWait=2, ChargingBecauseForceStateOn=3, NotChargingBecauseForceStateOff=4, NotChargingBecauseScheduler=5, NotChargingBecauseEnergyLimit=6, ChargingBecauseAwattarPriceLow=7, ChargingBecauseAutomaticStopTestLadung=8, ChargingBecauseAutomaticStopNotEnoughTime=9, ChargingBecauseAutomaticStop=10, ChargingBecauseAutomaticStopNoClock=11, ChargingBecausePvSurplus=12, ChargingBecauseFallbackGoEDefault=13, ChargingBecauseFallbackGoEScheduler=14, ChargingBecauseFallbackDefault=15, NotChargingBecauseFallbackGoEAwattar=16, NotChargingBecauseFallbackAwattar=17, NotChargingBecauseFallbackAutomaticStop=18, ChargingBecauseCarCompatibilityKeepAlive=19, ChargingBecauseChargePauseNotAllowed=20, NotChargingBecauseSimulateUnplugging=22, NotChargingBecausePhaseSwitch=23, NotChargingBecauseMinPauseDuration=24)
    public $lmsc				;	// R					milliseconds			Status					last model status change
    public $mca					;	// R/W					uint8					Config					minChargingCurrent
    //public $awc					;	// R/W					uint8					Config					awattar country (Austria=0, Germany=1)
    //public $awp					;	// R/W					float					Config					awattarMaxPrice in ct
    //public $awcp				;	// R					optional<object>		Status					awattar current price
    //public $ido					;	// R					optional<object>		Config					Inverter data override
    //public $frm					;	// R					uint8					Config					roundingMode PreferPowerFromGrid=0, Default=1, PreferPowerToGrid=2
    //public $fup					;	// R/W					bool					Config					usePvSurplus
    //public $awe					;	// R/W					bool					Config					useAwattar
    public $fst					;	// R/W					float					Config					startingPower in watts
    //public $fmt					;	// R/W					milliseconds			Config					minChargeTime in milliseconds
    //public $att					;	// R/W					seconds					Config					automatic stop time in seconds since day begin, calculation: (hours3600)+(minutes60)+(seconds)
    //public $ate					;	// R/W					double					Config					automatic stop energy in Wh
    //public $ara					;	// R/W					bool					Config					automatic stop remain in aWATTar
    public $acp					;	// R/W					bool					Config					allowChargePause (car compatiblity)
    //public $cco					;	// R/W					double					Config					car consumption (only stored for app)
    //public $esk					;	// R/W					bool					Config					energy set kwh (only stored for app)
    //public $fzf					;	// R/W					bool					Config					zeroFeedin
    //public $sh					;	// R/W					float					Config					stopHysteresis in W
    //public $psh					;	// R/W					float					Config					phaseSwitchHysteresis in W
    //public $po					;	// R/W					float					Config					prioOffset in W
    //public $zfo					;	// R/W					float					Config					zeroFeedinOffset in W
    //public $psmd				;	// R/W					milliseconds			Config					forceSinglePhaseDuration (in milliseconds)
    //public $sumd				;	// R/W					milliseconds			Config					simulate unpluging duration (in milliseconds)
    //public $mpwst				;	// R/W					milliseconds			Config					min phase wish switch time (in milliseconds)
    //public $mptwt				;	// R/W					milliseconds			Config					min phase toggle wait time (in milliseconds)
    //public $ferm				;	// R					uint8					Status					effectiveRoundingMode
    //public $mmp					;	// R					float					Status					maximumMeasuredChargingPower (debug)
    public $tlf					;	// R					bool					Status					testLadungFinished (debug)
    public $tls					;	// R					bool					Status					testLadungStarted (debug)
    public $atp					;	// R					optional<object>		Status					nextTripPlanData (debug)
    //public $lpsc				;	// R					milliseconds			Status					last pv surplus calculation
    //public $inva				;	// R					milliseconds			Status					age of inverter data
    //public $pgrid				;	// R					optional<float>			Status					pGrid in W
    //public $ppv					;	// R					optional<float>			Status					pPv in W
    //public $pakku				;	// R					optional<float>			Status					pAkku in W
    //public $deltap				;	// R					float					Status					deltaP
    public $pnp					;	// R					uint8					Status					numberOfPhases
    //public $deltaa				;	// R					float					Other					deltaA
    //public $pvopt_avergagePGrid	;	// R					float					Status					averagePGrid
    //public $pvopt_avergagePPV	;	// R					float					Status					averagePPv
    //public $pvopt_avergagePAkku	;	// R					float					Status					averagePAkku
    //public $mci					;	// R/W					milliseconds			Config					minimumChargingInterval in milliseconds (0 means disabled)
    //public $mcpd				;	// R/W					milliseconds			Config					minChargePauseDuration in milliseconds (0 means disabled)
    //public $mcpea				;	// R/W					optional<milliseconds>	Status					minChargePauseEndsAt (set to null to abort current minChargePauseDuration)
    //public $su					;	// R/W					bool					Config					simulateUnpluggingShort
    //public $sua					;	// R/W					bool					Config					simulateUnpluggingAlways
    //public $hsa					;	// R/W					bool					Config					httpStaAuthentication
    //public $var					;	// R					uint8					Constant					variant: max Ampere value of unit (11: 11kW/16A, 22: 22kW/32A)
    //public $loe					;	// R/W					bool					Config					Load balancing enabled
    //public $log					;	// R/W					string					Config					load_group_id
    //public $lop					;	// R/W					uint16					Config					load_priority
    //public $lof					;	// R/W					uint8					Config					load_fallback
    //public $map					;	// R/W					array					Config					load_mapping (uint8_t[3])
    //public $upo					;	// R/W					bool					Config					unlock_power_outage
    public $pwm					;	// R					uint8					Status					phase wish mode for debugging / only for pv optimizing / used for timers later (Force_3=0, Wish_1=1, Wish_3=2)
    //public $lfspt				;	// R					optional<milliseconds>	Status					last force single phase toggle
    //public $fsptws				;	// R					optional<milliseconds>	Status					force single phase toggle wished since
    //public $spl3				;	// R/W					float					Config					threePhaseSwitchLevel
    public $psm					;	// R/W					uint8					Config					phaseSwitchMode (Auto=0, Force_1=1, Force_3=2)
    //public $oct					;	// W					string					Other					firmware update trigger (must specify a branch from ocu)
    //public $ocu					;	// R					array					Status					list of available firmware branches
    //public $cwe					;	// R/W					bool					Config					cloud websocket enabled"
    public $cus					;	// R					uint8					Status					Cable unlock status (Unknown=0, Unlocked=1, UnlockFailed=2, Locked=3, LockFailed=4, LockUnlockPowerout=5)
    public $ffb					;	// R					uint8					Status					lock feedback (NoProblem=0, ProblemLock=1, ProblemUnlock=2)
    //public $fhz					;	// R					optional<float>			Status					Stromnetz frequency (~50Hz) or 0 if unknown
    public $loa					;	// R					optional<uint8>			Status					load balancing ampere
    //public $lot					;	// R/W					uint32					Config					load balancing total amp
    public $lotAmp				;
    public $lotTs				;
    //public $loty				;	// R/W					uint8					Config					load balancing type (Static=0, Dynamic=1)
    //public $cards				;	// R/W					array					Config					
    //public $ocppe				;	// R/W					bool					Config					OCPP enabled
    //public $ocppu				;	// R/W					string					Config					OCPP server url
    //public $ocppg				;	// R/W					bool					Config					OCPP use global CA Store
    //public $ocppcn				;	// R/W					bool					Config					OCPP skipCertCommonNameCheck
    //public $ocppss				;	// R/W					bool					Config					OCPP skipServerVerification
    //public $ocpps				;	// R					bool					Status					OCPP started
    //public $ocppc				;	// R					bool					Status					OCPP connected
    //public $ocppca				;	// R					null or milliseconds	Status					OCPP connected (timestamp in milliseconds since reboot) Subtract from reboot time (rbt) to get number of milliseconds since connected
    //public $ocppa				;	// R					bool					Status					OCPP connected and accepted
    //public $ocppaa				;	// R					null or milliseconds	Status					OCPP connected and accepted (timestamp in milliseconds since reboot) Subtract from reboot time (rbt) to get number of milliseconds since connected
    //public $ocpphHI				;	// R/W					seconds					Config					OCPP heartbeat interval (can also be read/written with GetConfiguration and ChangeConfiguration)
    //public $ocpphMVSI			;	// R/W					seconds					Config					OCPP meter values sample interval (can also be read/written with GetConfiguration and ChangeConfiguration)
    //public $ocpphCADI			;	// R/W					seconds					Config					OCPP clock aligned data interval (can also be read/written with GetConfiguration and ChangeConfiguration)
    //public $ocppd				;	// R/W					string					Config					OCPP dummy card id (used when no card has been used and charging is already allowed / starting)
    //public $ocppr				;	// R/W					bool					Config					OCPP rotate phases on charger
    //public $ocpple				;	// R					string or null			Status					OCPP last error
    //public $ocpplea				;	// R					null or milliseconds	Status					OCPP last error (timestamp in milliseconds since reboot) Subtract from reboot time (rbt) to get number of milliseconds since connected
    //public $ocpprl				;	// R/W					bool					Config					OCPP remote logging (usually only enabled by go-e support to allow debugging)
    //public $ocppck				;	// R/W					string					Config					OCPP client key
    //public $ocppcc				;	// R/W					string					Config					OCPP client cert
    //public $ocppsc				;	// R/W					string					Config					OCPP server cert



public function GoEChargerAPIV2 ($wallboxID, $wallboxToken){
    $this->setWallboxID($wallboxID);
    $this->setWallboxToken($wallboxToken);
    
    $this->loadJson();
    $this->decodeJson();
    $this->setJsonValues();
}

public function setWallboxID($wallboxID){
    $this->wallboxID = $wallboxID;
}
public function getWallboxID(){
    return $this->wallboxID;
}

public function setWallboxToken($wallboxToken){
    $this->wallboxToken = $wallboxToken;
}
public function getWallboxToken(){
    return $this->wallboxToken;
}

public function sendWallboxRequest($request){
    return file_get_contents($request);
}

public function getApiSuccess(){
    if(isset($this->amp))$result = true;
    else $result = false;

    return $result;
}

public function refreshData(){
    $this->loadJson();
    $this->decodeJson();
    $this->setJsonValues();
}

public function loadJson(){
    $this->$json = $this->sendWallboxRequest($this->getWallboxApiStatusUrl());
}

public function decodeJson(){
    $this->jsonDecoded = json_decode($this->$json, false, 5, 0);
}

public function setJsonValues(){

    $this->alw         =          $this->jsonDecoded->{'alw'};
	$this->acu         =          $this->jsonDecoded->{'acu'};
	$this->adi         =          $this->jsonDecoded->{'adi'};
	$this->dwo         =          $this->jsonDecoded->{'dwo'};
	$this->sse         =          $this->jsonDecoded->{'sse'};
    $this->ccwSsid     =          $this->jsonDecoded->{'ccw'}->{'ssid'};
	$this->rssi        =          $this->jsonDecoded->{'rssi'};
    $this->ama         =          $this->jsonDecoded->{'ama'};
    $this->amp         =          $this->jsonDecoded->{'amp'};
	$this->fna         =          $this->jsonDecoded->{'fna'};
    $this->frc         =          $this->jsonDecoded->{'frc'};
	$this->car         =          $this->jsonDecoded->{'car'};
	$this->err         =          $this->jsonDecoded->{'err'};
	$this->cbl         =          $this->jsonDecoded->{'cbl'};
    $this->cdiType     =          $this->jsonDecoded->{'cdi'}->{'type'};
    $this->cdiValue    =          $this->jsonDecoded->{'cdi'}->{'value'};
	$this->lccfi       =          $this->jsonDecoded->{'lccfi'};
	$this->lccfc       =          $this->jsonDecoded->{'lccfc'};
	$this->lcctc       =          $this->jsonDecoded->{'lcctc'};
	$this->tma0        =          $this->jsonDecoded->{'tma'}[0];
    $this->tma1        =          $this->jsonDecoded->{'tma'}[1];
    $this->nrgUL1      =          $this->jsonDecoded->{'nrg'}[0];
    $this->nrgUL2      =          $this->jsonDecoded->{'nrg'}[1];
    $this->nrgUL3      =          $this->jsonDecoded->{'nrg'}[2];
    $this->nrgUN       =          $this->jsonDecoded->{'nrg'}[3];
    $this->nrgIL1      =          $this->jsonDecoded->{'nrg'}[4];
    $this->nrgIL2      =          $this->jsonDecoded->{'nrg'}[5];
    $this->nrgIL3      =          $this->jsonDecoded->{'nrg'}[6];
    $this->nrgPL1      =          $this->jsonDecoded->{'nrg'}[7];
    $this->nrgPL2      =          $this->jsonDecoded->{'nrg'}[8];
    $this->nrgPL3      =          $this->jsonDecoded->{'nrg'}[9];
    $this->nrgPN       =          $this->jsonDecoded->{'nrg'}[10];
    $this->nrgPTotal   =          $this->jsonDecoded->{'nrg'}[11];
    $this->nrgPfL1     =          $this->jsonDecoded->{'nrg'}[12];
    $this->nrgPfL2     =          $this->jsonDecoded->{'nrg'}[13];
    $this->nrgPfL3     =          $this->jsonDecoded->{'nrg'}[14];
    $this->nrgPfN      =          $this->jsonDecoded->{'nrg'}[15];
	$this->modelStatus =          $this->jsonDecoded->{'modelStatus'};
	$this->lmsc        =          $this->jsonDecoded->{'lmsc'};
	$this->mca         =          $this->jsonDecoded->{'mca'};
	$this->fst         =          $this->jsonDecoded->{'fst'};
	$this->acp         =          $this->jsonDecoded->{'acp'};
	$this->tlf         =          $this->jsonDecoded->{'tlf'};
	$this->tls         =          $this->jsonDecoded->{'tls'};
	$this->atp         =          $this->jsonDecoded->{'atp'};
    $this->pnp         =          $this->jsonDecoded->{'pnp'};
	$this->pwm         =          $this->jsonDecoded->{'pwm'};
	$this->psm         =          $this->jsonDecoded->{'psm'};
	$this->cus         =          $this->jsonDecoded->{'cus'};
	$this->ffb         =          $this->jsonDecoded->{'ffb'};
	$this->loa         =          $this->jsonDecoded->{'loa'};
	$this->lotAmp      =          $this->jsonDecoded->{'lot'}->{'amp'};
    $this->lotTs       =          $this->jsonDecoded->{'lot'}->{'ts'};
}

public function getLoadingWatt(){

    $value = 0;
    if($this->nrgPL1>0) $value = $value + $this->nrgPL1;
    if($this->nrgPL2>0) $value = $value + $this->nrgPL2;
    if($this->nrgPL3>0) $value = $value + $this->nrgPL3;
    
    return $value;
}

public function getWallboxApiStatusUrlWithPlaceholder(){
    return "https://#wallboxID#.api.v3.go-e.io/api/status?token=#wallboxToken#&filter=alw,acu,adi,dwo,sse,ccw,rssi,ama,amp,fna,car,err,cbl,cdi,lccfi,lccfc,lcctc,tma,nrg,modelStatus,lmsc,mca,fst,acp,tlf,tls,atp,pnp,pwm,psm,cus,ffb,loa,lot";
}
public function getWallboxApiStatusUrl(){
    return str_replace("#wallboxToken#", $this->getWallboxToken(), str_replace("#wallboxID#", $this->getWallboxID(), $this->getWallboxApiStatusUrlWithPlaceholder()));
}

public function getWallboxApiSettingUrlWithPlaceholder(){
    return "1234";
    //return "https://#wallboxID#.api.v3.go-e.io/api/set?token=#wallboxToken#";
}
public function getWallboxApiSettingUrl(){
    return str_replace("#wallboxToken#", $this->getWallboxToken(), str_replace("#wallboxID#", $this->getWallboxID(), $this->getWallboxApiSettingUrlWithPlaceholder()));
}

public function getPhases(){
    return $this->pnp;
}

public function getPhasesSetting(){
    if($this->psm = 1) $phases = 1;
    elseif($this->psm = 2) $phases = 3;
    else $phases = -1;
    
    return $phases;
}

public function sendPhasesSetting($phaseSetting){
    if($phaseSetting = 1) $setting = 1;
    elseif($phaseSetting = 3) $setting = 2;
    else $setting = 0;

    return $this->sendWallboxRequest($this->getWallboxApiSettingUrl()."&"."psm=".$setting);    
}

public function getAmpereSetting(){
    return $this->amp;
}

public function sendAmpereSetting($ampereSetting){
    return $this->sendWallboxRequest($this->getWallboxApiSettingUrl()."&"."amp=".$ampereSetting);    
}

public function getVolt(){
    if($this->getPhasesSetting() == 3 or $this->getPhases() == 3){
        $volt = ($this->nrgUL1 + $this->nrgUL2 + $this->nrgUL3) / 3;
    }elseif($this->getPhasesSetting() == 1 or $this->getPhases() == 1){
        $volt = $this->nrgUL1;
    }else{
        $volt = 0;
    }
    return $volt;
}

public function getCarStatus(){

    if($this->car == 0){
        $carStatus[0] = -1;
        $carStatus[1] = "Unbekannt";
    }elseif($this->car == 5){
        $carStatus[0] = 0;
        $carStatus[1] = "Error";
    }elseif($this->car == 1){
        $carStatus[0] = 1;
        $carStatus[1] = "Kein Fahrzeug angeschlossen";
    }elseif($this->car == 3){
        $carStatus[0] = 2;
        $carStatus[1] = "Fahrzeug angeschlossen und bereit";
    }elseif($this->car == 4){
        $carStatus[0] = 3;
        $carStatus[1] = "Fahrzeug angeschlossen aber vollständig geladen oder verweigert den Ladestart";
    }elseif($this->car == 2){
        $carStatus[0] = 4;
        $carStatus[1] = "Fahrzeug lädt";
    }else{
        $carStatus[0] = -2;
        $carStatus[1] = "n/a";
    }

    return $carStatus;

}

public function getStatus(){
    //$status[0]: 0 = not charging; 1 = charging;
    //$status[1]: reason code

    if($this->modelStatus == 0){
        $status[0] = 0;
        $status[1] = 'NotChargingBecauseNoChargeCtrlData';
    }elseif($this->modelStatus == 1){
        $status[0] = 0;
        $status[1] = 'NotChargingBecauseOvertemperature';
    }elseif($this->modelStatus == 2){
        $status[0] = 0;
        $status[1] = 'NotChargingBecauseAccessControlWait';
    }elseif($this->modelStatus == 3){
        $status[0] = 1;
        $status[1] = 'ChargingBecauseForceStateOn';
    }elseif($this->modelStatus == 4){
        $status[0] = 0;
        $status[1] = 'NotChargingBecauseForceStateOff';
    }elseif($this->modelStatus == 5){
        $status[0] = 0;
        $status[1] = 'NotChargingBecauseScheduler';
    }elseif($this->modelStatus == 6){
        $status[0] = 0;
        $status[1] = 'NotChargingBecauseEnergyLimit';
    }elseif($this->modelStatus == 7){
        $status[0] = 1;
        $status[1] = 'ChargingBecauseAwattarPriceLow';
    }elseif($this->modelStatus == 8){
        $status[0] = 1;
        $status[1] = 'ChargingBecauseAutomaticStopTestLadung';
    }elseif($this->modelStatus == 9){
        $status[0] = 1;
        $status[1] = 'ChargingBecauseAutomaticStopNotEnoughTime';
    }elseif($this->modelStatus == 10){
        $status[0] = 1;
        $status[1] = 'ChargingBecauseAutomaticStop';
    }elseif($this->modelStatus == 11){
        $status[0] = 1;
        $status[1] = 'ChargingBecauseAutomaticStopNoClock';
    }elseif($this->modelStatus == 12){
        $status[0] = 1;
        $status[1] = 'ChargingBecausePvSurplus';
    }elseif($this->modelStatus == 13){
        $status[0] = 1;
        $status[1] = 'ChargingBecauseFallbackGoEDefault';
    }elseif($this->modelStatus == 14){
        $status[0] = 1;
        $status[1] = 'ChargingBecauseFallbackGoEScheduler';
    }elseif($this->modelStatus == 15){
        $status[0] = 1;
        $status[1] = 'ChargingBecauseFallbackDefault';
    }elseif($this->modelStatus == 16){
        $status[0] = 0;
        $status[1] = 'NotChargingBecauseFallbackGoEAwattar';
    }elseif($this->modelStatus == 17){
        $status[0] = 0;
        $status[1] = 'NotChargingBecauseFallbackAwattar';
    }elseif($this->modelStatus == 18){
        $status[0] = 0;
        $status[1] = 'NotChargingBecauseFallbackAutomaticStop';
    }elseif($this->modelStatus == 19){
        $status[0] = 1;
        $status[1] = 'ChargingBecauseCarCompatibilityKeepAlive';
    }elseif($this->modelStatus == 20){
        $status[0] = 1;
        $status[1] = 'ChargingBecauseChargePauseNotAllowed';
    }elseif($this->modelStatus == 22){
        $status[0] = 0;
        $status[1] = 'NotChargingBecauseSimulateUnplugging';
    }elseif($this->modelStatus == 23){
        $status[0] = 0;
        $status[1] = 'NotChargingBecausePhaseSwitch';
    }elseif($this->modelStatus == 24){
        $status[0] = 0;
        $status[1] = 'NotChargingBecauseMinPauseDuration';
    }else{
        $status[0] = -1;
        $status[1] = 'unknown';
    }
    
    return $status;
}

public function sendForceStateNeutral(){
    return $this->sendWallboxRequest($this->getWallboxApiSettingUrl()."&"."frc=0");
}

public function sendForceStateOff(){
    return $this->sendWallboxRequest($this->getWallboxApiSettingUrl()."&"."frc=1");
}

public function sendForceStateOn(){
    return $this->sendWallboxRequest($this->getWallboxApiSettingUrl()."&"."frc=2");
}

public function printJsonValues(){

    echo "alw: ".$this->alw."<br/>";
	echo "acu: ".$this->acu."<br/>";         
	echo "adi: ".$this->adi."<br/>";   
	echo "dwo: ".$this->dwo."<br/>";         
	echo "sse: ".$this->sse."<br/>";         
	echo "ccwSsid: ".$this->ccwSsid."<br/>";         
	echo "rssi: ".$this->rssi."<br/>";        
    echo "ama: ".$this->ama."<br/>";
    echo "amp: ".$this->amp."<br/>";
	echo "fna: ".$this->fna."<br/>";
    echo "frc: ".$this->frc."<br/>";
	echo "car: ".$this->car."<br/>";         
	echo "err: ".$this->err."<br/>";         
	echo "cbl: ".$this->cbl."<br/>";         
	echo "cdiType: ".$this->cdiType."<br/>";
    echo "cdiValue: ".$this->cdiValue."<br/>";         
	echo "lccfi: ".$this->lccfi."<br/>";      
	echo "lccfc: ".$this->lccfc."<br/>";      
	echo "lcctc: ".$this->lcctc."<br/>";      
	echo "tma0: ".$this->tma0."<br/>";         
    echo "tma1: ".$this->tma1."<br/>";         
	echo "nrgUL1: ".$this->nrgUL1."<br/>";
    echo "nrgUL2: ".$this->nrgUL2."<br/>";
    echo "nrgUL3: ".$this->nrgUL3."<br/>";
    echo "nrgUN: ".$this->nrgUN."<br/>";
    echo "nrgIL1: ".$this->nrgIL1."<br/>";
    echo "nrgIL2: ".$this->nrgIL2."<br/>";
    echo "nrgIL3: ".$this->nrgIL3."<br/>";
    echo "nrgPL1: ".$this->nrgPL1."<br/>";
    echo "nrgPL2: ".$this->nrgPL2."<br/>";
    echo "nrgPL3: ".$this->nrgPL3."<br/>";
    echo "nrgPN: ".$this->nrgPN."<br/>";
    echo "nrgPTotal: ".$this->nrgPTotal."<br/>";
    echo "nrgPfL1: ".$this->nrgPfL1."<br/>";
    echo "nrgPfL2: ".$this->nrgPfL2."<br/>";
    echo "nrgPfL3: ".$this->nrgPfL3."<br/>";
    echo "nrgPfN: ".$this->nrgPfN."<br/>";
	echo "modelStatus: ".$this->modelStatus."<br/>";
	echo "lmsc: ".$this->lmsc."<br/>";        
	echo "mca: ".$this->mca."<br/>";         
	echo "fst: ".$this->fst."<br/>";         
	echo "acp: ".$this->acp."<br/>";         
	echo "tlf: ".$this->tlf."<br/>";         
	echo "tls: ".$this->tls."<br/>";         
	echo "atp: ".$this->atp."<br/>";   
    echo "pnp: ".$this->pnp."<br/>";   
	echo "pwm: ".$this->pwm."<br/>";         
	echo "psm: ".$this->psm."<br/>";         
	echo "cus: ".$this->cus."<br/>";         
	echo "ffb: ".$this->ffb."<br/>";         
	echo "loa: ".$this->loa."<br/>";         
	echo "lotAmp: ".$this->lotAmp."<br/>"; 
    echo "lotTs: ".$this->lotTs."<br/>"; 

}

}


class Appere {

    private $wallbox;

    public $pv;
    private $wattsSurplus;
    
    private $pvSurplusWattMin;
    private $loadingRatioBatterieWallbox;
    private $socMinWallboxStart;
    private $socMaxPreferBattery;

    private $modus;
    private $modusStatus;
    private $modusNext;

    public function Appere(){
        $this->setWallbox();
        $this->setPV();

        $this->setSocMinWallboxStart(10);
        $this->setSocMaxPreferBattery(15);
        $this->setPvSurplusWattMin(1380);
        $this->setLoadingRatioBatterieWallbox(10);

        $this->loadAppereSettings();
        $this->handleModusSettings(null);

    }

    public function startProcessing(){
        
        if($this->getModus() == 'LoadingPV')$this->loadingPv();
        elseif($this->getModus() == 'LoadingSocBased')$this->loadingSocBased();

    }
   
    function loadAppereSettings(){

        $jsonFile = file_get_contents("testen.txt");

        $jsonDecoded = json_decode($jsonFile, false, 5, 0);

        $this->modus = $jsonDecoded->{'modus'};
        $this->modusStatus = $jsonDecoded->{'modusStatus'};
        $this->modusNext = $jsonDecoded->{'modusNext'};

    }

    function writeAppereSettings(){

        $appereSettings['modus'] = $this->getModus();
        $appereSettings['modusStatus'] = $this->getModusStatus();
        $appereSettings['modusNext'] = $this->getModusNext();

        file_put_contents("testen.txt", json_encode($appereSettings));

    }

    function setModus($modus){
        $this->modus = $modus;
    }
    function getModus(){
        return $this->modus;
    }

    function setModusStatus($modusStatus){
        $this->modusStatus = $modusStatus;
    }
    function getModusStatus(){
        return $this->modusStatus;
    }

    function setModusNext($modusNext){
        $this->modusNext = $modusNext;
    }
    function getModusNext(){
        return $this->modusNext;
    }

    function handleModusSettings($modusNext){
        
        $carStatus = $this->wallbox->getCarStatus();
        
        if($this->getModusStatus() == 'Started'){
            if($carStatus[0] <> 4){

                if($this->getModusNext()!=""){
                    $this->setModus($this->getModusNext());
                }else{
                    $this->setModus('LoadingPV');
                }
        
                if(isset($modusNext)){
                    $this->setModusNext($modusNext);
                }else{
                    $this->setModusNext('LoadingPV');
                }

                $this->setModusStatus('Waiting');
        
                $this->writeAppereSettings();

            }
        }

    }

    function handleModusStatus($modusStatus){

        $this->setModusStatus($modusStatus);
        
        $this->writeAppereSettings();
    }

    public function setWallbox(){
        $this->wallbox = new GoEChargerAPIV2();
        $this->wallbox->GoEChargerAPIV2("202259", "NIjcbMOBvbTe7i1sj4NBHnQ6XGeLNfCG");
    }

    public function setPV(){
        $this->pv = new SolaXCloudUserMonitoringAPI();
        $this->pv->SolaXCloudUserMonitoringAPI();
    }

    public function calculateWattsSurplus(){
        $pv = $this->pv;
        $wallbox = $this->wallbox;

        
        if($pv->getUsedPowerWatt() < $wallbox->getLoadingWatt()){
            $sumUsedPowerWatt = $pv->getUsedPowerWatt();
        }else{
            $sumUsedPowerWatt = $pv->getUsedPowerWatt() - $wallbox->getLoadingWatt();
        }

        $watt = $pv->getPvPowerWatt() - $sumUsedPowerWatt;

        if($watt < 0) $watt = 0;

        return $watt;
    }

    public function calculateWatts (int $ampere, int $phases){
        return $ampere * $phases * $this->wallbox->getVolt();
    }

    public function calculateAmperePhases (int $watts){
        $phase1MinWatts = 6 * $this->wallbox->getVolt();
        $phase3MinWatts = $phase1MinWatts * 3;

        echo "<br/>Test: ".$phase1MinWatts." ".$phase3MinWatts." ".$this->wallbox->getVolt() ;

        if($watts >= $phase3MinWatts){
            
            for($i = 16; $i >= 6 && !isset($result[1]); $i--){
                if($this->calculateWatts($i, 3) <= $watts) $result[1] = $i;
            }
            $result[0] = 3;

        }else if($watts > $phase1MinWatts){
            
            for($i = 16; $i >= 6 && !isset($result[1]); $i--){
                if($this->calculateWatts($i, 1) <= $watts) $result[1] = $i;
            }
            $result[0] = 1;
        }

        return $result;
    }

    public function setPvSurplusWattMin($pvSurplusWattMin){
        $this->pvSurplusWattMin = $pvSurplusWattMin;
    }
    public function getPvSurplusWattMin(){
        return $this->pvSurplusWattMin;
    }

    public function setLoadingRatioBatterieWallbox($loadingRatioBatterieWallbox){
        $this->loadingRatioBatterieWallbox = $loadingRatioBatterieWallbox;
    }
    public function getLoadingRatioBatterieWallbox(){
        if(!isset($this->loadingRatioBatterieWallbox))$this->loadingRatioBatterieWallbox = 0;
        return $this->loadingRatioBatterieWallbox;
    }

    public function setSocMinWallboxStart($socMinWallboxStart){
        $this->socMinWallboxStart = $socMinWallboxStart;
    }
    public function getSocMinWallboxStart(){
        return $this->socMinWallboxStart;
    }

    public function setSocMaxPreferBattery($socMaxPreferBattery){
        $this->socMaxPreferBattery = $socMaxPreferBattery;
    }
    public function getSocMaxPreferBattery(){
        return $this->socMaxPreferBattery;
    }
    
    public function startLoadingDirectly(){
        return $this->wallbox->sendForceStateOn();
    }

    public function allowLoadingNeutral(){
        return $this->wallbox->sendForceStateNeutral();
    }

    public function stopLoadingDirectlyHard(){
        return $this->wallbox->sendForceStateOff();
    }

    public function stopLoadingDirectlySoft(){
        return $this->wallbox->sendForceStateNeutral();
    }

    public function loadingSocBased(){
        $result = null;
        $carStatus = $this->wallbox->getCarStatus();

        echo "<br/>"."loadingSocBased";

        echo "<br/>".$this->pv->getSocPercent()." ".$this->getSocMinWallboxStart();

        if($this->pv->getSocPercent() <= $this->getSocMinWallboxStart()){

            echo "<br/>"."SOC OK ".$carStatus[0];

            if($carStatus[0] == 2 or $carStatus[0] == 1){

                echo "<br/>"."Start";

                $result = $this->wallbox->sendForceStateOn();
    
                $this->handleModusStatus("Started");
            }

        }
        
        return $result;
    }

    public function loadingPv(){
        $start = false;
        $result = null;
        $wattsSurplus = $this->calculateWattsSurplus();
        $status = $this->wallbox->getStatus();
        $carStatus = $this->wallbox->getCarStatus();

        if($this->pv->getApiSuccess() and $this->wallbox->getApiSuccess()){

            if($carStatus[0] >= 2){

                echo "<br/>"."Prüfung: Batterie soll mindestens zu ".$this->getSocMinWallboxStart()." % gefüllt sein. Aktueller Ladestand: ".$this->pv->getSocPercent()." %";

                if($this->pv->getSocPercent() >= $this->getSocMinWallboxStart()){

                    echo "<br/>"."Prüfung: Überschuss ".$wattsSurplus." W von mindestens benötigten " .$this->getPvSurplusWattMin()." W";

                    if($wattsSurplus > $this->getPvSurplusWattMin()){

                        echo "<br/>"."Prüfung: Batterie-Ladestand ".$this->pv->getSocPercent()." % von mindestens benötigten ".$this->getSocMaxPreferBattery()." %";
                        
                        $loadingWatts = $wattsSurplus;

                        if($this->pv->getSocPercent() <= $this->getSocMaxPreferBattery() and $this->getLoadingRatioBatterieWallbox() > 0){

                            $reducedWatts = $wattsSurplus / 100 * (100 - $this->getLoadingRatioBatterieWallbox());

                            if($reducedWatts > $this->getPvSurplusWattMin()){

                                $loadingWatts = $reducedWatts;
                                echo "<br/>"."Leistung wegen SOC reduziert.";

                            }else{

                                $loadingWatts = 0;

                                echo "<br/>"."Kein Laden möglich, da Limit zu niedrig.";

                            }

                        }else{
                            echo "<br/>"."Keine Reduzierung, da SOC > max";
                        }

                        if($loadingWatts > $this->getPvSurplusWattMin()){

                            echo "<br/>"."Ergebnis: Überschuss für Wallbox reicht mit ".$loadingWatts." W aus, da mehr als ".$this->getPvSurplusWattMin()." W.";

                            $settings = $this->calculateAmperePhases($loadingWatts);
                            
                            if(isset($settings)){
                                
                                $phase = $settings[0];
                                $ampere = $settings[1];

                                echo "<br/>"."Benötigte Einstellung: ".$phase." Phase(n) mit ".$ampere." Ampere.";

                                $phaseSetting = $this->wallbox->getPhasesSetting();
                                $ampereSetting = $this->wallbox->getAmpereSetting();

                                if($phaseSetting != $phase){
                                    echo "<br/>"."Phasen-Umstellung von ".$phaseSetting." auf ".$phase;
                                    $this->wallbox->sendPhasesSetting($phase);
                                }

                                if($ampereSetting != $ampere){
                                    echo "<br/>"."Ampere-Umstellung von ".$ampereSetting." auf ".$ampere;
                                    $this->wallbox->sendAmpereSetting($ampere);
                                }
                                
                                echo "<br/>"."Test".$status[0]."<br/>".$status[1];

                                if($status[0] == 0){
                                    echo "<br/>"."Wallbox gestartet";
                                    $this->wallbox->sendForceStateOn();
                                }
                                
                            }

                        }elseif($status[0] == 1){
                            echo "<br/>"."Ergebnis: Überschuss für die Wallbox reicht nicht aus.";
                            echo "<br/>"."Entscheidung: Batterie soll zuerst geladen werden.";
                            echo "<br/>"."Aktion: Wallbox beenden.";
                            $this->wallbox->sendForceStateOff();

                        }else{
                            echo "<br/>"."Ergebnis: Überschuss für die Wallbox reicht nicht aus.";
                            echo "<br/>"."Entscheidung: Batterie soll zuerst geladen werden.";
                        }

                    }elseif($status[0] == 1) {

                        echo "<br/>"."Abschaltung, da Überschuss zu gering.";
                        $this->wallbox->sendForceStateOff();
                    }else{

                        echo "<br/>"."Überschuss zu gering";
                    }

                }elseif($status[0] == 1) {

                    echo "<br/>"."Abschaltung, da Batterie-Ladestand zu gering.";
                    $this->wallbox->sendForceStateOff();
                }else{

                    echo "<br/>"."Kein Wallbox-Start, da Batterie-Ladestand zu gering.";
                }
            
            }else{

                echo "<br/>"."Fahrzeug nicht ladebereit.";
            }
            
        
        }else{

            echo "<br/>"."API-Problem.";
        }

    }

}



$appere = new Appere();
$appere->Appere();

$appere->startProcessing();


echo"<br/><br/>";
echo"PV-Leistung: ".$appere->pv->getPvPowerWatt()."<br/>";
echo"Verbrauch: ".$appere->pv->getUsedPowerWatt()."<br/>";
echo"Netzeinspeisung: ".$appere->pv->getFeedinPowerWatt()."<br/>";
echo"Überschuss: ".$appere->calculateWattsSurplus()."<br/>";
echo"<br/><br/>";



//////////////////////////////////////////////////////






//echo file_get_contents("https://qhome-ess-g3.q-cells.eu/proxyApp/proxy/api/getRealtimeInfo.do?tokenId=20220713034306409515821&sn=SW5QA9JKJR");





















?>



