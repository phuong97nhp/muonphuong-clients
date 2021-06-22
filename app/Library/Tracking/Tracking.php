<?php

// khai báo thời gian việt nam
date_default_timezone_set('Asia/Ho_Chi_Minh');

class Tracking
{
    public  $date_entered; // thời gian nhập bill 
    public $address_state; // mã khu vực


    // mã tỉnh huyện
    public  $maMienTay = "TGG^,^TGG^,^TVH^,^BTE^,^STG^,^HGG1^,^DTP^,^TGG1^,^LAN1^,^TVH1^,^STG1^,^BTE1^,^DTP1^,^HGG11^,^AGG^,^AGG1^,^BLU^,^BLU1^,^BTE1^,^VLG^,^VLG1^,^KGG^,^KGG1^,^CTO1^,^CTO^,^CTO2^,^LAN^,^CMU^,^CMU1";

    public  $maTinhTayNamBo = "NTN^,^NTN1^,^BTN^,^BTN1^,^BPC^,^BPC1^,^VTU^,^TNH^,^TNH1^,^VTU21^,^VTU2^,^DNI2^,^DNI21^,^DNI^,^BDG21^,^BDG2^,^BDH^,^BDH1^,^PYN^,^PYN1^,^KHA^,^KHA1^,^PYN^,^HCM1";

    public  $maTinhMienTrung = "DKG^,^DKG1^,^QNM^,^QNM^,^QNI^,^QNI1^,^HUE^,^HUE1^,^DKG^,^DKG1^,^HTH^,^HTH1^,^QBH^,^QBH1^,^NAN^,^NAN1^,^QTI^,^QTI1^,^THA^,^THA1^,^QNG^,^QNG1^,^DNG^,^DNG1";


    public  $maTinhMienBac = "HNI^,^HNI1^,^BKN^,^BKN1^,^BGG^,^BGG1^,^BNH^,^BNH1^,^CBG^,^CBG1^,^DBN^,^DBN1^,^HGG^,^HGG1*^,^HNM^,^HNM1^,^HDG^,^HDG1^,^HPG^,^HPG1^,^HBH^,^HBH1^,^HYN^,^HYN1^,^LCU^,^LCU1^,^LCI^,^LCI1^,^LSN^,^LSN1^,^NDH^,^NDH1^,^NBH^,^NBH1^,^PTO^,^PTO1^,^QNH^,^QNH1^,^SLA^,^SLA1^,^TBH^,^TBH1^,^TNN^,^TNN1^,^TQG^,^TQG1^,^VPC^,^VPC1^,^YBI^,^YBI1^,^NBH^,^NBH1";

    public $maTinhTayNguyen = "KTM^,^KTM1^,^GLI^,^GLI1^,^DLK^,^DLK1^,^DKG^,^DKG1^,^LDG^,^LDG1";

    public $HCM = "HCM^,^HCM2";
    public $HNI = "HNI^,^HNI1";

    // mã 64 tỉnh thành phố
    public $TinhThanhPho = "AGG^,^BKN^,^BGG^,^BNH^,^BTE^,^BDH^,^BDG^,^BDG2^,^BPC^,^BTN^,^VTU^,^VTU2^,^CMU^,^CTO^,^CTO2^,^CBG^,^DNG^,^DLK^,^DKG^,^DBN^,^DNI^,^DNI2^,^DTP^,^GLI^,^HGG^,^HNM^,^HNI^,^HTH^,^HDG^,^HPG^,^HGG1^,^HCM3^,^HCM2^,^HCM^,^HBH^,^KHA^,^KHA2^,^KGG^,^KTM^,^LCU^,^LDG^,^LSN^,^LCI^,^LCI^,^LAN2^,^LAN^,^NDH^,^NAN^,^NBH^,^NTN^,^PTO^,^PYN^,^QBH^,^QNM^,^QNI^,^QNH^,^QTI^,^STG^,^SLA^,^TNH^,^TBH^,^TBH^,^TNN^,^THA^,^HUE^,^TGG^,^TVH^,^TQG^,^VLG^,^QNG^,^VPC^,^YBI^,^HCM^,^HCM2^,^HCM1";

    function __construct($date_entered, $address_state)
    {
        $this->date_entered = $date_entered;
        $this->address_state = $address_state;
    }

    // set lại thời gian cộng thêm 7
    public function setTimeViNa()
    {
        $time = strtotime($this->date_entered);
        return date("Y/m/d H:i:s", $time + 7 * 60 * 60);
    }

    // thời gian nhập vào
    public function setTimeEnter()
    {
        static $time_enter = 0;
        $date = date_create($this->setTimeViNa());
        date_modify($date, "0 days");
        return $time_enter = date_format($date, "Y/m/d H:i:s");
    }

    // đi khỏi bưu cục
    public function outPost($setTime, $hours = 1)
    {
        $time = strtotime($setTime);
        return date("Y/m/d H:i:s", $time + (($hours * 60 * 60) + 90));
    }
}

class Track_slow extends Tracking
{

    // đi đến các trung tâm khai thác
    private $haNoi = 3; // trung tâm khai thác số 1 
    private $canTho = 1.2; // trung tâm khai thác số 3
    private $daNang = 2; // trung tâm khai thác số 2
    private $buonMaThuoc = 2; // trung tâm khai thác số 2
    private $hoChiMinh = 1;
    private $tayNamBo = 1;

    // đi đến các tỉnh và các huyện
    private $phiaBac = 1;
    private $mienTay = 1.3;
    private $mienTrung = 1;
    private $tayNguyen = 1;

    // thời gian đến trung tâm khai thác
    public function ArrivalatPost($setTime)
    {

        $category_tty = explode('^,^',  $this->maMienTay);
        $category_mt = explode('^,^', $this->maTinhMienTrung);
        $category_mb = explode('^,^', $this->maTinhMienBac);
        $category_tn = explode('^,^', $this->maTinhTayNguyen);
        $category_hcm = explode('^,^', $this->HCM);
        $category_tnb = explode('^,^', $this->maTinhTayNamBo);

        if (in_array("$this->address_state", $category_tty)) {

            $time = strtotime($this->outPost($setTime, 1));
            return date("Y/m/d H:i:s", $time + ($this->canTho * 60 * 60 * 24) + 35);
        } elseif (in_array("$this->address_state", $category_mt)) {

            $time = strtotime($this->outPost($setTime, 3));
            return date("Y/m/d H:i:s", $time + ($this->daNang * 60 * 60 * 24) + 25);
        } elseif (in_array("$this->address_state", $category_mb)) {

            $time = strtotime($this->outPost($setTime, 4));
            return date("Y/m/d H:i:s", $time + ($this->haNoi * 60 * 60 * 24) + 15);
        } elseif (in_array("$this->address_state", $category_tn)) {

            $time = strtotime($this->outPost($setTime, 2));
            return date("Y/m/d H:i:s", $time + ($this->buonMaThuoc * 60 * 60 * 24) + 5);
        } elseif (in_array("$this->address_state", $category_hcm)) {

            $time = strtotime($this->outPost($setTime, 2));
            return date("Y/m/d H:i:s", $time + ($this->hoChiMinh * 60 * 60 * 24) + 5);
        } elseif (in_array("$this->address_state", $category_tnb)) {

            $time = strtotime($this->outPost($setTime, 2));
            return date("Y/m/d H:i:s", $time + ($this->tayNamBo * 60 * 60 * 24) + 6);
        }
    }

    // đển tỉnh huyện 

    public function ArrivalatPostChildren($setTime)
    {
        $thanhpho = explode('^,^',  $this->TinhThanhPho);
        $category_tty = explode('^,^',  $this->maMienTay);
        $category_mt = explode('^,^', $this->maTinhMienTrung);
        $category_mb = explode('^,^', $this->maTinhMienBac);
        $category_tn = explode('^,^', $this->maTinhTayNguyen);
        $category_hcm = explode('^,^', $this->HCM);
        $category_tnb = explode('^,^', $this->maTinhTayNamBo);

        if (in_array("$this->address_state", $thanhpho)) {
            // chỉ có tỉnh trung tâm
            if (in_array("$this->address_state", $category_tty)) {

                $time = strtotime(parent::outPost($setTime, 1));
                return date("Y/m/d H:i:s", $time + ($this->mienTay * 60 * 60 * 24) + 35);
            } elseif (in_array("$this->address_state", $category_mt)) {

                $time = strtotime(parent::outPost($setTime, 3));
                return date("Y/m/d H:i:s", $time + ($this->mienTrung * 60 * 60 * 24) + 25);
            } elseif (in_array("$this->address_state", $category_mb)) {

                $time = strtotime(parent::outPost($setTime, 4));
                return date("Y/m/d H:i:s", $time + ($this->phiaBac * 60 * 60 * 24) + 15);
            } elseif (in_array("$this->address_state", $category_tn)) {

                $time = strtotime(parent::outPost($setTime, 2));
                return date("Y/m/d H:i:s", $time + ($this->tayNguyen * 60 * 60 * 24) + 5);
            }
            // elseif (in_array("$this->address_state", $category_tnb)) {

            //     $time = strtotime($this->outPost($setTime, 2));
            //     return date("Y/m/d H:i:s", $time + ($this->tayNamBo * 60 * 60 * 24) + 6);
            // }
        } else {

            //về đến huyện xã 
            if (in_array("$this->address_state", $category_tty)) {

                $time = strtotime(parent::outPost($setTime, 1));
                return date("Y/m/d H:i:s", $time + (($this->mienTay / (3 / 2)) * 60 * 60 * 24) + 35);
            } elseif (in_array("$this->address_state", $category_mt)) {

                $time = strtotime(parent::outPost($setTime, 3));
                return date("Y/m/d H:i:s", $time + (($this->mienTrung / (3 / 2)) * 60 * 60 * 24) + 25);
            } elseif (in_array("$this->address_state", $category_mb)) {

                $time = strtotime(parent::outPost($setTime, 4));
                return date("Y/m/d H:i:s", $time + (($this->phiaBac / (3 / 2)) * 60 * 60 * 24) + 15);
            } elseif (in_array("$this->address_state", $category_tn)) {

                $time = strtotime(parent::outPost($setTime, 2));
                return date("Y/m/d H:i:s", $time + (($this->tayNguyen / (3 / 2)) * 60 * 60 * 24) + 5);
            }
        }
    }

    // về đến huyện xã

    public function ArrivalatPostChildrenHX($setTime)
    {
        $thanhpho = explode('^,^',  $this->TinhThanhPho);
        $category_tty = explode('^,^',  $this->maMienTay);
        $category_mt = explode('^,^', $this->maTinhMienTrung);
        $category_mb = explode('^,^', $this->maTinhMienBac);
        $category_tn = explode('^,^', $this->maTinhTayNguyen);

        if (!in_array("$this->address_state", $thanhpho)) {

            //về đến huyện xã 
            if (in_array("$this->address_state", $category_tty)) {

                $time = strtotime(parent::outPost($setTime, 1));
                return date("Y/m/d H:i:s", $time + (($this->mienTay / (3 / 1)) * 60 * 60 * 24) + 35);
            } elseif (in_array("$this->address_state", $category_mt)) {

                $time = strtotime(parent::outPost($setTime, 3));
                return date("Y/m/d H:i:s", $time + (($this->mienTrung / (3 / 1)) * 60 * 60 * 24) + 25);
            } elseif (in_array("$this->address_state", $category_mb)) {

                $time = strtotime(parent::outPost($setTime, 4));
                return date("Y/m/d H:i:s", $time + (($this->phiaBac / (3 / 1)) * 60 * 60 * 24) + 15);
            } elseif (in_array("$this->address_state", $category_tn)) {

                $time = strtotime(parent::outPost($setTime, 2));
                return date("Y/m/d H:i:s", $time + (($this->tayNguyen / (3 / 1)) * 60 * 60 * 24) + 5);
            }
        }
    }
}


class Track_fast extends Tracking
{

    // đi đến các trung tâm khai thác
    private $haNoi = 1; // trung tâm khai thác số 1 
    private $canTho = 1; // trung tâm khai thác số 3
    private $daNang = 1; // trung tâm khai thác số 2
    private $buonMaThuoc = 1; // trung tâm khai thác số 2
    private $hoChiMinh = 1;
    private $tayNamBo = 0.7;

    // đi đến các tỉnh và các huyện
    private $phiaBac = 1;
    private $mienTay = 0.2;
    private $mienTrung =  0.3;
    private $tayNguyen =  0.3;
    private $mienTayNamBo = 0.3;

    public function ArrivalatPostFast($setTime, $hours)
    {
        $hcm = explode('^,^',  $this->HCM);
        $hni = explode('^,^',  $this->HNI);
        $thanhpho = explode('^,^',  $this->TinhThanhPho);
        $category_tty = explode('^,^',  $this->maMienTay);
        $category_mt = explode('^,^', $this->maTinhMienTrung);
        $category_mb = explode('^,^', $this->maTinhMienBac);
        $category_tn = explode('^,^', $this->maTinhTayNguyen);
        $category_tnb = explode('^,^', $this->maTinhTayNamBo);

        if (in_array("$this->address_state", $hcm)) {

            $time = strtotime(parent::outPost($setTime, $hours));
            return date("Y/m/d H:i:s", $time + (($this->hoChiMinh + $hours) * 60 * 60 * 24) + 35);
        } elseif (in_array("$this->address_state", $category_mb)) {

            $time = strtotime(parent::outPost($setTime, $hours));
            return date("Y/m/d H:i:s", $time + (($this->haNoi + $hours) * 60 * 60 * 24) + 90);
        } elseif (in_array("$this->address_state", $category_tn)) {

            $time = strtotime(parent::outPost($setTime, $hours));
            return date("Y/m/d H:i:s", $time + (($this->buonMaThuoc + $hours) * 60 * 60 * 24) + 90);
        } elseif (in_array("$this->address_state", $category_tnb)) {

            $time = strtotime(parent::outPost($setTime, $hours));
            return date("Y/m/d H:i:s", $time + (($this->tayNamBo + $hours) * 60 * 60 * 24) + 90);
        } else {

           $time = strtotime(parent::outPost($setTime, $hours));
            return date("Y/m/d H:i:s", $time + ((1 + $hours) * 60 * 60 * 24) + 95);
        }
    }

    public function ArrivalatPostFastHX($setTime, $hours)
    {
        $hcm = explode('^,^',  $this->HCM);
        $hni = explode('^,^',  $this->HNI);
        $category_mb = explode('^,^', $this->maTinhMienBac);
        if (in_array("$this->address_state", $hcm)) {
            $time = strtotime(parent::outPost($setTime, $hours));
            return date("Y/m/d H:i:s", $time + (($this->mienTayNamBo + $hours) * 60 * 60 * 24) + 35);
        } elseif (in_array("$this->address_state", $category_mb)) {
            $time = strtotime(parent::outPost($setTime, $hours));
            return date("Y/m/d H:i:s", $time + (($this->phiaBac + $hours) * 60 * 60 * 24) + 35);
        } else {
            $time = strtotime(parent::outPost($setTime, $hours));
            return date("Y/m/d H:i:s", $time + (($this->mienTay + $hours) * 60 * 60 * 24) + 35);
        }
    }
}


class ShowTracking extends Tracking
{

    public $name; // số bill
    public $type; // hình thức vận chuyển
    public $address_tp; // tên thành phố 
    public $province_from; // mã tỉnh đi 
    public $name_to; // Người nhận 
    public $address_to; // Địa chỉ đến
    public $date_to; // Địa chỉ đến
    public $accounts_code; // Địa chỉ đến

    // khai báo static để gắn giá trị thời gian sau mỗi lần cập nhật
    static  $timeTracking = 0;
    static $date_create = 0;

    // khai báo giá trị của mãng theo khu vực 
    public $dataTracking = array();

    // khai báo $html = "";
    public $html = "";

    // khah hang khong hien thi tracking
    public $arr_accounts = array('TCV2', 'TCVTV');

    // khai báo trung tâm khai thác 
    protected $ttkt1 = "trung tâm khai thác số 1 (Hà Nội)";
    protected $ttkt2 = "trung tâm khai thác số 2 (Đà Nẵng)";
    protected $ttkt3 = "trung tâm khai thác số 3 (Cần Thơ)";
    protected $ttkt4 = "trung tâm khai thác số 4 (Buôn Ma Thuột)";


    function __construct($date_entered, $address_state, $name, $type, $address_tp, $province_from, $name_to, $address_to, $date_to, $accounts_code)
    {
        parent::__construct($date_entered, $address_state);

        // khai báo
        $this->name = $name;
        $this->type = $type;
        $this->address_tp = $address_tp;
        $this->province_from = $province_from;
        $this->name_to = $name_to;
        $this->address_to = $address_to;
        $this->date_to = $date_to;
        $this->accounts_code = $accounts_code;
    }



    // kiểm tra khu vực hiện đang ở 
    protected function setLocation()
    {
        $thanhpho = explode('^,^',  $this->TinhThanhPho);
        $category_tty = explode('^,^',  $this->maMienTay);
        $category_mt = explode('^,^', $this->maTinhMienTrung);
        $category_mb = explode('^,^', $this->maTinhMienBac);
        $category_tn = explode('^,^', $this->maTinhTayNguyen);
        $category_hcm = explode('^,^', $this->HCM);
        $category_tinh = explode('^,^', $this->TinhThanhPho);
      
        if (in_array("$this->address_state", $category_tty)) {
            return $this->ttkt3;
        } elseif (in_array("$this->address_state", $category_mt)) {
            return $this->ttkt2;
        } elseif (in_array("$this->address_state", $category_mb)) {
            return $this->ttkt1;
        } elseif (in_array("$this->address_state", $category_tn)) {
            return $this->ttkt4;
        }
    }

    protected function titleCase($string, $delimiters = array(" ", "-", ".", "'", "O'", "Mc"), $exceptions = array("and", "to", "of", "das", "dos", "I", "II", "III", "IV", "V", "VI"))
    {
        $string = mb_convert_case($string, MB_CASE_TITLE, "UTF-8");
        foreach ($delimiters as $dlnr => $delimiter) {
            $words = explode($delimiter, $string);
            $newwords = array();
            foreach ($words as $wordnr => $Word) {
                if (in_array(mb_strtoupper($Word, "UTF-8"), $exceptions)) {
                    // check exceptions list for any words that should be in upper case
                    $Word = mb_strtoupper($Word, "UTF-8");
                } elseif (in_array(mb_strtolower($Word, "UTF-8"), $exceptions)) {
                    // check exceptions list for any words that should be in upper case
                    $Word = mb_strtolower($Word, "UTF-8");
                } elseif (!in_array($Word, $exceptions)) {
                    // convert to uppercase (non-utf8 only)
                    $Word = ucfirst($Word);
                }
                array_Push($newwords, $Word);
            }
            $string = join($delimiter, $newwords);
        } //foreach
        return $string;
    }

    // chuyển đổi quận huyện 
    protected function setCity()
    {
        $unHX = $this->titleCase($this->address_tp);
        if (strpos($this->address_tp, "- HX") !== false) {
            // nếu như có tồ tại
            return str_replace('- Hx', '', $unHX);
        }elseif(strpos($this->address_tp, "HX") !== false) {
            // nếu như có tồ tại
            return str_replace(' Hx', '', $unHX);
        }elseif(strpos($this->address_tp, "-HX") !== false) {
            // nếu như có tồ tại
            return str_replace('-Hx', '', $unHX);
        } else {
            // nếu như không tồn tại
            return $unHX;
        }
    }

    public function show($code)
    {

        // chuyển chuổi thành mãng ra tỉnh thành
        $thanhpho = explode('^,^',  $this->TinhThanhPho);
        $category_tty = explode('^,^',  $this->maMienTay);
        $category_mt = explode('^,^', $this->maTinhMienTrung);
        $category_mb = explode('^,^', $this->maTinhMienBac);
        $category_tn = explode('^,^', $this->maTinhTayNguyen);
        $category_hcm = explode('^,^', $this->HCM);
        $category_tinh = explode('^,^', $this->TinhThanhPho);
        $category_tnb = explode('^,^', $this->maTinhTayNamBo);

        // gán giá trị cho biến 
        $type = $this->type;
        if ($this->province_from == "HCM" || $this->province_from == "hcm") {
            if ($type == 'BD34' ||  $type == 'BD45' || $type == 'BD78' || $type == 'DBExpress' || $type == ' ĐB' || $type == 'DBSave') {

                // gọi class Giao nhận chậm
                $Track_slow = new Track_slow($this->date_entered, $this->address_state);

                // chấp nhận gửi
                $timeTracking = $Track_slow->setTimeEnter();
                $date_create = date_create($timeTracking);
                $dataTracking[] = array(
                    "another_date" => $timeTracking,
                    "date" => date_format($date_create, "d/m/Y"),
                    "time" => date_format($date_create, "H:i:s"),
                    "status" => "Chấp nhận gửi (Posting/collection)",
                    "location" => "Trung tâm giao dịch Hồ Chí Minh"
                );

                // Đi khỏi  bưu cục Hồ Chí Minh
                $timeTracking = $Track_slow->outPost($timeTracking, 3);
                $date_create = date_create($timeTracking);
                $dataTracking[] = array(
                    "another_date" => $timeTracking,
                    "date" => date_format($date_create, "d/m/Y"),
                    "time" => date_format($date_create, "H:i:s"),
                    "status" => "Đi khỏi bưu cục (Departure from PO)",
                    "location" => "Trung tâm giao dịch Hồ Chí Minh"
                );

                if (in_array("$this->address_state", $category_hcm)) {

                    // là Hồ Chí Minh
                    $timeTracking = $Track_slow->ArrivalatPost($timeTracking);
                    $date_create = date_create($timeTracking);
                    $dataTracking[] = array(
                        "another_date" => $timeTracking,
                        "date" => date_format($date_create, "d/m/Y"),
                        "time" => date_format($date_create, "H:i:s"),
                        "status" => "Đã chuyển đến khu vực Quận của " . $this->setCity() . "(ArrivalatPost)",
                        "location" => 'Trung tâm giao dịch khu vực ' . ucfirst($this->setCity())
                    );
                } elseif (in_array("$this->address_state", $category_tnb)) {

                    //thuộc các tỉnh miền tay nam bộ
                    $timeTracking = $Track_slow->ArrivalatPost($timeTracking);
                    $date_create = date_create($timeTracking);
                    $dataTracking[] = array(
                        "another_date" => $timeTracking,
                        "date" => date_format($date_create, "d/m/Y"),
                        "time" => date_format($date_create, "H:i:s"),
                        "status" => "Đã chuyển đến khu vực " . $this->setCity() . "(ArrivalatPost)",
                        "location" => 'Đã chuyển đến khu vực ' . ucfirst($this->setCity())
                    );
                } else {

                    if (!in_array("$this->address_state", array("HCM1"))) {
                        // Đến trung tâm khai thác
                        $timeTracking = $Track_slow->ArrivalatPost($timeTracking);
                        $date_create = date_create($timeTracking);
                        $dataTracking[] = array(
                            "another_date" => $timeTracking,
                            "date" => date_format($date_create, "d/m/Y"),
                            "time" => date_format($date_create, "H:i:s"),
                            "status" => "Đã đến " . $this->setLocation() . "(ArrivalatPost)",
                            "location" => ucfirst($this->setLocation())
                        );
                    }


                    if (!in_array("$this->address_state", array("HCM1","HNI", "CTO", "DNG","HNI1", "CTO1", "DNG1"))) {
                        // Đi khỏi  trung tâm khai thác
                        $timeTracking = $Track_slow->outPost($timeTracking, 0.5);
                        $date_create = date_create($timeTracking);
                        $dataTracking[] = array(
                            "another_date" => $timeTracking,
                            "date" => date_format($date_create, "d/m/Y"),
                            "time" => date_format($date_create, "H:i:s"),
                            "status" => "Đi khỏi  " . $this->setLocation() . " (Departure from PO)",
                            "location" => ucfirst($this->setLocation())
                        );
                    }

                    if (!in_array("$this->address_state", array("HCM1","HNI", "CTO", "DNG","HNI1", "CTO1", "DNG1"))) {
                    // Đến khu vực thành phố
                    $timeTracking = $Track_slow->ArrivalatPostChildren($timeTracking);
                    $date_create = date_create($timeTracking);
                    $dataTracking[] = array(
                        "another_date" => $timeTracking,
                        "date" => date_format($date_create, "d/m/Y"),
                        "time" => date_format($date_create, "H:i:s"),
                        "status" => "Đã đến khu vực TP." . $this->setCity() . " (ArrivalatPost)",
                        "location" => "Đến khu vực  TP." . $this->setCity()
                    );
                    }   
                }

                // trường hợp là huyện xã
                if (!in_array("$this->address_state", $category_tinh) && !in_array("$this->address_state", $category_tnb) &&!in_array("$this->address_state", array("HCM1","HNI", "CTO", "DNG","HNI1", "CTO1", "DNG1"))) {
                    // Đi khỏi  trung tâm thành phố
                    $timeTracking = $Track_slow->outPost($timeTracking, 0.5);
                    $date_create = date_create($timeTracking);
                    $dataTracking[] = array(
                        "another_date" => $timeTracking,
                        "date" => date_format($date_create, "d/m/Y"),
                        "time" => date_format($date_create, "H:i:s"),
                        "status" => "Đi khỏi  khu vực TP." . $this->setCity() . "(Departure from PO)",
                        "location" => "Đến khu vực  TP." . $this->setCity()
                    );

                    // đế khu vực huyện xã
                    $timeTracking = $Track_slow->ArrivalatPostChildrenHX($timeTracking);
                    $date_create = date_create($timeTracking);
                    $dataTracking[] = array(
                        "another_date" => $timeTracking,
                        "date" => date_format($date_create, "d/m/Y"),
                        "time" => date_format($date_create, "H:i:s"),
                        "status" => "Đã chuyển về khu vực huyện của tỉnh " . $this->setCity() . "(ArrivalatPost)",
                        "location" => "Khu vực tỉnh " . $this->setCity()
                    );
                }

                //Đã giao cho bưu tá
                $timeTracking = $Track_slow->outPost($timeTracking, 0.5);
                $date_create = date_create($timeTracking);
                $dataTracking[] = array( 
                    "another_date" => $timeTracking,   
                    "date" => date_format($date_create, "d/m/Y"),
                    "time" => date_format($date_create, "H:i:s"),
                    "status" => "Đã chuyển cho bưu tá đi phát (Shipper)",
                    "location" => "Khu vực tỉnh " . $this->setCity()
                );
            } else {

                // gọi class Giao nhận nhanh
                $Track_fast = new Track_fast($this->date_entered, $this->address_state);

                // "====================hình thức chuyển phát đi nhanh =========";
                // chấp nhận gửi
                $timeTracking = $Track_fast->setTimeEnter();
                $date_create = date_create($timeTracking);
                $dataTracking[] = array(
                    "another_date" => $timeTracking,
                    "date" => date_format($date_create, "d/m/Y"),
                    "time" => date_format($date_create, "H:i:s"),
                    "status" => "Chấp nhận gửi (Posting/collection)",
                    "location" => "Trung tâm giao dịch Hồ Chí Minh"
                );

                if (!in_array("$this->address_state", array('HCM', 'HCM2'))) {
                   // Đi khỏi  bưu cục Hồ Chí Minh
                    $timeTracking = $Track_fast->outPost($timeTracking, 3);
                    $date_create = date_create($timeTracking);
                    $dataTracking[] = array(
                        "another_date" => $timeTracking,
                        "date" => date_format($date_create, "d/m/Y"),
                        "time" => date_format($date_create, "H:i:s"),
                        "status" => "Đi khỏi bưu cục (Departure from PO)",
                        "location" => "Trung tâm giao dịch Hồ Chí Minh"
                    );
                }
                
                if(in_array("$this->address_state", $category_mb)) {
                    
                    // Đến trung tâm khai thác
                    $timeTracking = $Track_fast->ArrivalatPostFast($timeTracking, 0.1);
                    $date_create = date_create($timeTracking);
                    $dataTracking[] = array(
                        "another_date" => $timeTracking,
                        "date" => date_format($date_create, "d/m/Y"),
                        "time" => date_format($date_create, "H:i:s"),
                        "status" => "Đã đến " . $this->setLocation() . "(ArrivalatPost)",
                        "location" => ucfirst($this->setLocation())
                    );
                    if (!in_array("$this->address_state", array("HNI","HNI1"))) {
                        // Đi khỏi  trung tâm khai thác
                        $timeTracking = $Track_fast->outPost($timeTracking, 0.5);
                        $date_create = date_create($timeTracking);
                        $dataTracking[] = array(
                            "another_date" => $timeTracking,
                            "date" => date_format($date_create, "d/m/Y"),
                            "time" => date_format($date_create, "H:i:s"),
                            "status" => "Đi khỏi  " . $this->setLocation() . " (Departure from PO)",
                            "location" => ucfirst($this->setLocation())
                        );
                    }

                    // đã đến khu vực tỉnh
                    if (!in_array("$this->address_state", array("HNI","HNI1"))) {
                        $timeTracking = $Track_fast->ArrivalatPostFastHX($timeTracking, 0.1);
                        $date_create = date_create($timeTracking);
                        $dataTracking[] = array(
                            "another_date" => $timeTracking,
                            "date" => date_format($date_create, "d/m/Y"),
                            "time" => date_format($date_create, "H:i:s"),
                            "status" => "Đã đến khu vực TP." . $this->setCity() . "(ArrivalatPost)",
                            "location" => "Đến khu vực  TP." . $this->setCity()
                        );
                    }
                    
                }else {

                    //nếu không phải là miền bắc
                    if (!in_array("$this->address_state", array("HNI","HNI1",'HCM', 'HCM2'))) {
                        $timeTracking = $Track_fast->ArrivalatPostFast($timeTracking, 0.3);
                        $date_create = date_create($timeTracking);
                        $dataTracking[] = array(
                            "another_date" => $timeTracking,
                            "date" => date_format($date_create, "d/m/Y"),
                            "time" => date_format($date_create, "H:i:s"),
                            "status" => "Đã đến khu vực TP.".$this->setCity(),
                            "location" => "Đến khu vực  TP." . $this->setCity()
                        );
                    }

                }

                //Đã giao cho bưu tá
                $timeTracking = $Track_fast->outPost($timeTracking, 1.6);
                $date_create = date_create($timeTracking);
                $dataTracking[] = array(
                    "another_date" => $timeTracking,
                    "date" => date_format($date_create, "d/m/Y"),
                    "time" => date_format($date_create, "H:i:s"),
                    "status" => "Đã chuyển cho bưu tá đi phát (Shipper)",
                    "location" => "Đã chuyển đến " . $this->setCity()
                );
            }

            // chuyển phát thành công
            $nameTo = $this->titleCase($this->name_to);
            $addressTo = $this->titleCase($this->address_to);
            $date_toTracking = date_create($this->date_to);
            if (!empty($nameTo)) {
                $timeTracking = date_format($date_toTracking, "Y/m/d H:i:s");
                $date_create = date_create($timeTracking);
                $dataTracking[] = array(
                    "another_date" => $timeTracking,
                    "date" => date_format($date_create, "d/m/Y"),
                    "time" => date_format($date_create, "H:i:s"),
                    "status" => "Đã phát cho (Ông/Bà) $nameTo",
                    "location" => "$addressTo"
                );
            }

            // đơn hàng từ 247 post
            // $url_here = "https://tracking.247post.vn/api/Order/v1/Tracking?ordercode=MP$code&apikey=B3059854-5366-4250-A2CD-F66F0A4018DF";
            // $json = file_get_contents($url_here); 
            // $obj = json_decode($json); 
            // if($obj->errorCode == null || $obj->errorCode != 'ORDERCODE_NOT_FOUND'){
            //     // giá trị track trả về bằng mãng 
            //     $datas = array_reverse($obj->trackings);
            //     foreach ($datas as $data) {
            //         $date=date_create($data->dateChange);
            //         $this->html .= '<tr>
            //             <td>' . date_format($date, "d/m/Y") . '</td>
            //             <td>' . date_format($date, "H:i:s") . '</td>
            //             <td>' . $data->statusName . '</td>
            //             <td>Trung tâm khai thác ' .$data->postOfficeName.' - '. ucfirst($data->provinceName) . '</td>
            //         </tr>';
            //     }
            //     $result['images'] = $obj->confirmImage;
            // }else{
                // giá trị track trả về bằng mãng 
                $datas = array_reverse($dataTracking);
                $today = date("Y/m/d H:i:s");
                //echo $today."<br>";
                // giá trị ra về là html
                if(!in_array("$this->accounts_code", $this->arr_accounts)){
                    foreach ($datas as $data) {
                        if(strtotime($today) > strtotime($data['another_date'])){
                        $this->html .= '<tr>
                            <td>' . $data['date'] . '</td>
                            <td>' . $data['time'] . '</td>
                            <td>' . $data['status'] . '</td>
                            <td>' . $data['location'] . '</td>
                        </tr>';
                        }
                    }
                }else {
                    $this->html .= '<tr>
                            <td colspan="4"> Bạn là khách hàng riêng nên cần liên hệ nhân viên công ty. </td>
                        </tr>';
                }
            // }

            $result['html'] = $this->html;
            
            return  $result;
        }
    }
}