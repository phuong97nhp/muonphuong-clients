<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\ProjectNames as MProjectNames;
use Illuminate\Support\Facades\Log;
use App\Models\BaoPhat;
use Carbon\Carbon;

class checkBill247 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:checkBill247';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Chương trình này đảm nhiệm lấy dữ liệu từ trang web 247 về website của Muôn Phương';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */

     // php artisan schedule:list
     // php artisan command:checkBill247
    public function handle()
    {
        $intLimit  = 500;
        $intPage = 0;
        $i = 0;
        while(true){
            $intOffset = ($intPage*$intLimit);
            $getProjectName = MProjectNames::where('status', 0)->orderBy('id', 'desc')->offset($intOffset)->limit($intLimit)->get();
            $strIdEnter = 'e9374ed9-cc10-9211-d647-5cfcfe82f0e4';
            foreach ($getProjectName as $key => $value) {
                $strCodeBill = (string) trim($value->name);
                $strDate = date('Y-m-d H:i:s');
                $strUrlApi247 = "https://tracking.247post.vn/api/Order/v1/Tracking?ordercode=MP$strCodeBill&apikey=B3059854-5366-4250-A2CD-F66F0A4018DF";
                $jsonApi247 = file_get_contents($strUrlApi247); 
                $arrApi247 = json_decode($jsonApi247, true); 

                if($arrApi247['statusName'] == 'PHATTHANHCONG'){
                    $strWeight = $arrApi247['weight'];
                    $strDeliveryDate = date_format(date_create($arrApi247['deliveryDate']), 'Y-m-d H:i:s');
                    $strReceiverName = $this->w1250_to_utf8($this->getSlug($arrApi247['receiverName']));

                    $valBaoPhat = [
                        'id' => DB::raw('NEWID()'), 
                        'name' => $strCodeBill, 
                        'date_entered' => $strDate, 
                        'date_modified' => $strDate, 
                        'modified_user_id' => $strIdEnter, 
                        'deleted' => 0, 
                        'assigned_user_id' => $strIdEnter, 
                        'account_name' => $strIdEnter, 
                        'user_code' => 'phuong97np-bot', 
                        'date_start' => $strDate, 
                        'weight' => $strWeight, 
                        'package' => '', 
                        'date_receive' => $strDeliveryDate,
                        'created_by' => $strIdEnter,
                        'status' => 1,
                        'receiver_name' => (string) $strReceiverName, 
                        'pod_source' => 'bot'
                    ];
                    BaoPhat::insert($valBaoPhat);

                    $valProductName = [
                        'times_get' => DB::raw('times_get+1'),
                        'status' => 1,
                    ];
                }else{
                    $valProductName = [
                        'times_get' => DB::raw('times_get+1'),
                        'status' => 0,
                    ];
                }
                MProjectNames::where('name', $strCodeBill)->update($valProductName);
            }
            if(count($getProjectName) < $intLimit){
                break;
            }else{
                $intPage += 1;
            }
            echo $i++;
            echo "\n";
        }

        echo $i* $intLimit;
    }

    public function w1250_to_utf8($text) {
        $map = array(
            chr(0x8A) => chr(0xA9),
            chr(0x8C) => chr(0xA6),
            chr(0x8D) => chr(0xAB),
            chr(0x8E) => chr(0xAE),
            chr(0x8F) => chr(0xAC),
            chr(0x9C) => chr(0xB6),
            chr(0x9D) => chr(0xBB),
            chr(0xA1) => chr(0xB7),
            chr(0xA5) => chr(0xA1),
            chr(0xBC) => chr(0xA5),
            chr(0x9F) => chr(0xBC),
            chr(0xB9) => chr(0xB1),
            chr(0x9A) => chr(0xB9),
            chr(0xBE) => chr(0xB5),
            chr(0x9E) => chr(0xBE),
            chr(0x80) => '&euro;',
            chr(0x82) => '&sbquo;',
            chr(0x84) => '&bdquo;',
            chr(0x85) => '&hellip;',
            chr(0x86) => '&dagger;',
            chr(0x87) => '&Dagger;',
            chr(0x89) => '&permil;',
            chr(0x8B) => '&lsaquo;',
            chr(0x91) => '&lsquo;',
            chr(0x92) => '&rsquo;',
            chr(0x93) => '&ldquo;',
            chr(0x94) => '&rdquo;',
            chr(0x95) => '&bull;',
            chr(0x96) => '&ndash;',
            chr(0x97) => '&mdash;',
            chr(0x99) => '&trade;',
            chr(0x9B) => '&rsquo;',
            chr(0xA6) => '&brvbar;',
            chr(0xA9) => '&copy;',
            chr(0xAB) => '&laquo;',
            chr(0xAE) => '&reg;',
            chr(0xB1) => '&plusmn;',
            chr(0xB5) => '&micro;',
            chr(0xB6) => '&para;',
            chr(0xB7) => '&middot;',
            chr(0xBB) => '&raquo;',
        );
        return html_entity_decode(mb_convert_encoding(strtr($text, $map), 'UTF-8', 'ISO-8859-1'), ENT_QUOTES, 'UTF-8');
    }


    public static function getSlug($string, $maxLength = 1000, $separator = ' ') {
        $arrCharFrom = array("ạ", "á", "à", "ả", "ã", "Ạ", "Á", "À", "Ả", "Ã", "â", "ậ", "ấ", "ầ", "ẩ", "ẫ", "Â", "Ậ", "Ấ", "Ầ", "Ẩ", "Ẫ", "ă", "ặ", "ắ", "ằ", "ẳ", "ẵ", "ẫ", "Ă", "Ắ", "Ằ", "Ẳ", "Ẵ", "Ặ", "Ẵ", "ê", "ẹ", "é", "è", "ẻ", "ẽ", "Ê", "Ẹ", "É", "È", "Ẻ", "Ẽ", "ế", "ề", "ể", "ễ", "ệ", "Ế", "Ề", "Ể", "Ễ", "Ệ", "ọ", "ộ", "ổ", "ỗ", "ố", "ồ", "Ọ", "Ộ", "Ổ", "Ỗ", "Ố", "Ồ", "Ô", "ô", "ó", "ò", "ỏ", "õ", "Ó", "Ò", "Ỏ", "Õ", "ơ", "ợ", "ớ", "ờ", "ở", "ỡ", "Ơ", "Ợ", "Ớ", "Ờ", "Ở", "Ỡ", "ụ", "ư", "ứ", "ừ", "ử", "ữ", "ự", "Ụ", "Ư", "Ứ", "Ừ", "Ử", "Ữ", "Ự", "ú", "ù", "ủ", "ũ", "Ú", "Ù", "Ủ", "Ũ", "ị", "í", "ì", "ỉ", "ĩ", "Ị", "Í", "Ì", "Ỉ", "Ĩ", "ỵ", "ý", "ỳ", "ỷ", "ỹ", "Ỵ", "Ý", "Ỳ", "Ỷ", "Ỹ", "đ", "Đ");
        $arrCharEnd = array("a", "a", "a", "a", "a", "A", "A", "A", "A", "A", "a", "a", "a", "a", "a", "a", "A", "A", "A", "A", "A", "A", "a", "a", "a", "a", "a", "a", "a", "A", "A", "A", "A", "A", "A", "A", "e", "e", "e", "e", "e", "e", "E", "E", "E", "E", "E", "E", "e", "e", "e", "e", "e", "E", "E", "E", "E", "E", "o", "o", "o", "o", "o", "o", "O", "O", "O", "O", "O", "O", "O", "o", "o", "o", "o", "o", "O", "O", "O", "O", "o", "o", "o", "o", "o", "o", "O", "O", "O'", "O", "O", "O", "u", "u", "u", "u", "u", "u", "u", "U", "U", "U", "U", "U", "U", "U", "u", "u", "u", "u", "U", "U", "U", "U", "i", "i", "i", "i", "i", "I", "I", "I", "I", "I", "y", "y", "y", "y", "y", "Y", "Y", "Y", "Y", "Y", "d", "D");
        $arrCharnonAllowed = array("©", "®", "Æ", "Ç", "Å", "Ç", "๏", "๏̯͡๏", "Î", "Ø", "Û", "Þ", "ß", "å", "", "¼", "æ", "ð", "ñ", "ø", "û", "!", "ñ", "[", "\"", "$", "%", "'", "(", ")", "♥", "(", "+", "*", "/", "\\", ",", ":", "¯", "", "+", ";", "<", ">", "=", "?", "@", "`", "¶", "[", "]", "^", "~", "`", "|", "", "_", "?", "*", "{", "}", "€", "�", "ƒ", "„", "", "…", "‚", "†", "‡", "ˆ", "‰", "ø", "´", "Š", "‹", "Œ", "�", "Ž", "�", "ॐ", "۩", "�", "‘", "’", "“", "”", "•", "۞", "๏", "—", "˜", "™", "š", "›", "œ", "�", "ž", "Ÿ", "¡", "¢", "£", "¤", "¥", "¦", "§", "¨", "«", "¬", "¯", "°", "±", "²", "³", "´", "µ", "¶", "¸", "¹", "º", "»", "¼", "¾", "¿", "Å", "Æ", "Ç", "?", "×", "Ø", "Û", "Þ", "ß", "å", "æ", "ç", "ï", "ð", "ñ", "÷", "ø", "ÿ", "þ", "û", "½", "☺", "☻", "♥", "♦", "♣", "♠", "•", "░", "◘", "○", "◙", "♂", "♀", "♪", "♫", "☼", "►", "◄", "↕", "‼", "¶", "§", "▬", "↨", "↑", "↓", "←", "←", "↔", "▲", "▼", "⌂", "¢", "→", "¥", "ƒ", "ª", "º", "▒", "▓", "│", "┤", "╡", "╢", "╖", "╕", "╣", "║", "╗", "╝", "╜", "╛", "┐", "└", "┴", "┬", "├", "─", "┼", "╞", "╟", "╚", "╔", "╩", "╦", "╠", "═", "╬", "╧", "╨", "╤", "╥", "╙", "╘", "╒", "╓", "╫", "╪", "┘", "┌", "█", "▄", "▌", "▐", "▀", "α", "Γ", "π", "Σ", "σ", "µ", "τ", "Φ", "Θ", "Ω", "δ", "∞", "φ", "ε", "∩", "≡", "±", "≥", "≤", "⌠", "⌡", "≈", "°", "∙", "·", "√", "ⁿ", "²", "■", "¾", "×", "Ø", "Þ", "ð", "ღ", "ஐ", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "•", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "•", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "Ƹ", 'Ӝ', 'Ʒ', "★", "●", "♡", "ஜ", "ܨ");
        $string = str_replace($arrCharFrom, $arrCharEnd, $string);
        $finalString = str_replace($arrCharnonAllowed, '', $string);
        $url = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $finalString);
        $url = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $url);
        $url = trim(substr(strtolower($url), 0, $maxLength));
        $url = preg_replace("/[\/_|+ -]+/", $separator, $url);
        return $url;
    }
}
