<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Users\RegistryDog;
use App\Models\Users\RegistryCat;
use App\Models\Users\RegistryRabbit;
use App\Models\Users\RegistryBird;
use App\Models\Users\PetGeneration;


class CertificateController extends Controller
{
    /* ANIMAL CERTIFICATE */
    public function Create_certificate_animal_registration(Request $request)
    {
        $font_paths = array(
            'fonts/avenirltstd-black.otf',
            'fonts/avenirltstd-book.otf',
            'fonts/avenirltstd-roman.otf',

            'fonts/MrDafoe-Regular.ttf',
            'fonts/PublicSans-BlackItalic.ttf',
            'fonts/PublicSans-Black.ttf',

            'fonts/PublicSans-BoldItalic.ttf',
            'fonts/PublicSans-Bold.ttf',
            'fonts/PublicSans-ExtraBold.ttf'
        );

        $validated = Validator::make($request->all(),[
            'pet_type' => 'required'
        ]);
        if ($validated->fails()) {
            print_r($request->input('pet_type')); exit();
            return redirect()->back();
        }

        header('Content-type: image/png');

        switch ($request->input('pet_type')) {
            case 'dog':
                $home = 'KENNEL';
                $cert_template = 'img/certificate_templates/dog-registration-TEMPLATE.png';
                break;
            case 'cat':
                $home = 'CATTERY';
                $cert_template = 'img/certificate_templates/cat-registration-TEMPLATE.png';
                break;
            case 'rabbit':
                $home = 'RABBITRY';
                $cert_template = 'img/certificate_templates/rabbit-registration-TEMPLATE.png';
                break;
            case 'bird':
                $home = 'COOP';
                $cert_template = 'img/certificate_templates/bird-registration-TEMPLATE.png';
                break;
            
            default: break;
        }

        $img = imagecreatefrompng($cert_template);
        $color = imagecolorallocate($img, 255, 255, 255);

        $width  = imagesx($img);
        $height = imagesy($img);

        imagecreatetruecolor($width, $height);

        imagealphablending($img, true);
        imagesavealpha($img, true);

        imagecolortransparent($img, $color);

        // * CENTERING
        $center_constant = 120;


        // SET NAME
        $name_limit = 4200;

        if ($request->input('pet_name_cb') == 'on') {
            $size = 250;
            $angle = 0;
            $txt = strtoupper($request->input('pet_name'));
            $font_path = $font_paths[5];
            $fcolor = imagecolorallocate($img, 0, 0, 0);

            $txt_dimension = imageftbbox($size, $angle, $font_path, $txt);

            while (($txt_dimension[2] - $txt_dimension[0]) > $name_limit) {
                $size -= 5;
                $txt_dimension = imageftbbox($size, $angle, $font_path, $txt);
            }
            imagefttext(
                $img, 
                $size, 
                $angle, 
                $center_constant + ($width - ($txt_dimension[2] - $txt_dimension[0])) / 2, 
                1475 + ($txt_dimension[1] - $txt_dimension[7]), 
                $fcolor, 
                $font_path, 
                $txt
            );
        }

        // SET BREED
        if ($request->input('pet_breed_cb') == 'on') {
            $size = 68;
            $angle = 0;
            $txt = $request->input('pet_breed');
            $font_path = $font_paths[2];
            $fcolor = imagecolorallocate($img, 0, 0, 0);

            $txt_dimension = imageftbbox($size, $angle, $font_path, $txt);

            imagefttext(
                $img, 
                $size, 
                $angle, 
                $center_constant + ($width - ($txt_dimension[2] - $txt_dimension[0])) / 2, 
                1824 + ($txt_dimension[1] - $txt_dimension[7]), 
                $fcolor, 
                $font_path, 
                $txt
            );
        }

        // SET LOWER RIGHT INFO
        $det_x = 295;
        $det_y = 3230; // 2367
        $det_h = 120;

        $det_arr = array();

        if ($request->input('pet_verification_level_cb') == 'on') {
            $det_arr[7] = 'LEVEL OF VERIFICATION:';
        }
        if ($request->input('pet_microchip_no_cb') == 'on') {
            $det_arr[6] = 'MICROCHIP NO. ' . $request->input('pet_microchip_no');
        }
        if ($request->input('pet_breeder_cb') == 'on') {
            $det_arr[5] = 'BREEDER: ' . ucwords($request->input('pet_breeder'));
        }
        if ($request->input('pet_home_cb') == 'on') {
            $det_arr[4] = $home . ': ' . ucwords($request->input('pet_home'));
        }
        if ($request->input('pet_owner_cb') == 'on') {
            $det_arr[3] = 'OWNER: ' . ucwords($request->input('pet_owner'));
        }
        if ($request->input('pet_gender_cb') == 'on') {
            $det_arr[2] = 'GENDER: ' . ucwords($request->input('pet_gender'));
        }
        if ($request->input('pet_birthdate_cb') == 'on') {
            $det_arr[1] = 'DATE OF BIRTH: ' . date('F d, Y', strtotime($request->input('pet_birthdate')));
        }
        if ($request->input('pet_no_cb') == 'on') {
            $det_arr[0] = $request->input('pet_no');
        }
        $verification_level = $request->input('pet_verification_level');


        $det_y_ctr = 0;
        foreach ($det_arr as $key => $val) {
            if (isset($val)) {
                $size = 64;
                $angle = 0;
                $txt = $val;
                $fcolor = imagecolorallocate($img, 0, 0, 0);
                $txt_dimension = imagefttext(
                    $img, 
                    $size, 
                    $angle, 
                    $det_x, 
                    $det_y - ($det_y_ctr * $det_h), 
                    $fcolor, 
                    $font_paths[1], 
                    $txt
                );

                if ($key == 7) {
                    $txt_width = $txt_dimension[2] - $txt_dimension[0];

                    for ($i = 0; $i < $verification_level; $i++) {
                        $star_img = 'img/certificate_templates/stars.png';
                        $star_size = 91;

                        $img_created = imagecreatefrompng($star_img);
                        imagealphablending($img_created, true);

                        imagecopyresampled(
                            $img, 
                            $img_created, 
                            $det_x + $txt_width + ($star_size * $i) + (35 * ($i + 1)), // details offset x + txt label width  + (star width * star count) + (star margin)
                            $det_y - ($det_y_ctr * $det_h) - $star_size + 15, 
                            0, 
                            0, 
                            $star_size, $star_size, // img size x y
                            imagesx($img_created), 
                            imagesy($img_created)
                        );
                    }
                }
                
                $det_y_ctr++;
            }
        }


        $watermark = 'img/certificate_templates/peds-watermark.png';
        $img_created = imagecreatefrompng("$watermark");
        $img_created = imagescale($img_created, $width, $height);
        imagecopy($img, $img_created, 
            0, 0, // dest x,y
            0, 0, // offset
            $width, $height // width height
        );


        imagepng($img);
    }

    /* ANIMAL PEDIGREE */
    public function Create_certificate_animal_pedigree(Request $request)
    {
        // $sire_breeds = $request->input('pet_sirebreed');
        // print_r($sire_breeds);exit();
        $font_paths = array(
            'fonts/avenirltstd-black.otf',
            'fonts/avenirltstd-book.otf',
            'fonts/avenirltstd-roman.otf',

            'fonts/MrDafoe-Regular.ttf',
            'fonts/PublicSans-BlackItalic.ttf',
            'fonts/PublicSans-Black.ttf',

            'fonts/PublicSans-BoldItalic.ttf',
            'fonts/PublicSans-Bold.ttf',
            'fonts/PublicSans-ExtraBold.ttf'
        );

        $validated = Validator::make($request->all(),[
            'pet_type' => 'required'
        ]);
        if ($validated->fails()) {
            return redirect()->back();
        }

        header('Content-type: image/png');

        // > BASE TEMPLATE
        $no_generations = $request->input('generations');
        switch ($no_generations) {
            case 2:
                $cert_template = 'img/certificate_templates/1-pedigree-TEMPLATE.png';
                break;
            case 3:
                $cert_template = 'img/certificate_templates/2-pedigree-TEMPLATE.png';
                break;
            case 4:
                $cert_template = 'img/certificate_templates/3-pedigree-TEMPLATE.png';
                break;
            case 5:
                $cert_template = 'img/certificate_templates/4-pedigree-TEMPLATE.png';
                break;

            default: break;
        }

        $img = imagecreatefrompng($cert_template);
        $color = imagecolorallocate($img, 255, 255, 255);

        $width  = imagesx($img);
        $height = imagesy($img);

        imagecreatetruecolor($width, $height);

        imagealphablending($img, true);
        imagesavealpha($img, true);

        imagecolortransparent($img, $color);
        // < BASE TEMPLATE

        // > LOGO
        switch ($request->input('pet_type')) {
            case 'dog':
                $home = 'KENNEL';
                $cert_logo = 'img/certificate_templates/dog-pedigree-TEMPLATE.png';
                break;
            case 'cat':
                $home = 'CATTERY';
                $cert_logo = 'img/certificate_templates/cat-pedigree-TEMPLATE.png';
                break;
            case 'rabbit':
                $home = 'RABBITRY';
                $cert_logo = 'img/certificate_templates/rabbit-pedigree-TEMPLATE.png';
                break;
            case 'bird':
                $home = 'COOP';
                $cert_logo = 'img/certificate_templates/bird-pedigree-TEMPLATE.png';
                break;

            default: break;
        }

        $pet_img = $cert_logo;
        $img_created = imagecreatefrompng("$pet_img");
        $img_created = imagescale($img_created, $width, $height);
        imagecopy($img, $img_created, 
            0, 0, // dest x,y
            0, 0, // offset
            $width, $height // width height
        );
        // < LOGO

        $img1_param = array(
            2 => array(
                'w' => 307,
                'h' => 444,
                'x' => 153,
                'y' => 488,
            ),
            3 => array(
                'w' => 307,
                'h' => 444,
                'x' => 152,
                'y' => 481,
            ),
            4 => array(
                'w' => 249,
                'h' => 358,
                'x' => 146,
                'y' => 506,
            ),
            5 => array(
                'w' => 249,
                'h' => 360,
                'x' => 146,
                'y' => 506,
            ),
        );

        $img2_param = array(
            2 => array(
                'w' => 209,
                'h' => 303,
                'x' => 1178,
                'y' => 358,
            ),
            3 => array(
                'w' => 164,
                'h' => 239,
                'x' => 1173,
                'y' => 365,
            ),
            4 => array(
                'w' => 164,
                'h' => 239,
                'x' => 874,
                'y' => 365,
            ),
            5 => array(
                'w' => 164,
                'h' => 239,
                'x' => 819,
                'y' => 373,
            ),
        );

        $img3_param = array(
            2 => array(
                'w' => 209,
                'h' => 303,
                'x' => 1178,
                'y' => 754,
            ),
            3 => array(
                'w' => 164,
                'h' => 239,
                'x' => 1173,
                'y' => 784,
            ),
            4 => array(
                'w' => 164,
                'h' => 239,
                'x' => 874,
                'y' => 784,
            ),
            5 => array(
                'w' => 164,
                'h' => 239,
                'x' => 819,
                'y' => 792,
            ),
        );

        // PET image (307x446) (154,487)
        if ($request->input('pet_img_cb') == 'on') {
            $pet_img = 'img/no_img.jpg'; // default image
            if ($request->hasFile('pet_img')) {
                $pet_img = $request->file('pet_img');
            }

            $img_size = GetImageSize($pet_img);

            if($img_size[2] == 1) // if gif
            $img_created = imagecreatefromgif("$pet_img");
            if($img_size[2] == 2) // if jpg
            $img_created = imagecreatefromjpeg("$pet_img");
            if($img_size[2] == 3) // if png
            $img_created = imagecreatefrompng("$pet_img");

            $dest_w = $new_w = $img1_param[$no_generations]['w']; // first: 307
            $dest_h = $new_h = $img1_param[$no_generations]['h']; // first: 446

            $img_ratio = imagesx($img_created) / imagesy($img_created);
            $dest_ratio = $dest_w / $dest_h;
            if ($img_ratio < $dest_ratio) {
                $new_h = $new_w / $img_ratio;
                $new_w = $new_h * $img_ratio;
            }
            else {
                $new_w = $new_h * $img_ratio;
                $new_h = $new_w / $img_ratio;
            }
            $img_created = imagescale($img_created, $new_w, $new_h);
            imagecopy($img, $img_created, 
                $img1_param[$no_generations]['x'], $img1_param[$no_generations]['y'], // dest 154,487
                ($new_w - $dest_w) / 2, ($new_h - $dest_h) / 2, // dest offset
                $dest_w, $dest_h // width height
            );
        }

        // SIRE image (209x302) (1128,358)
        if ($request->input('pet_sireimg_cb') == 'on') {
            $pet_sireimg = 'img/no_img.jpg'; // default image
            if ($request->hasFile('pet_sireimg')) {
                $pet_sireimg = $request->file('pet_sireimg');
            }

            $img_size = GetImageSize($pet_sireimg);

            if($img_size[2] == 1) // if gif
            $img_created = imagecreatefromgif("$pet_sireimg");
            if($img_size[2] == 2) // if jpg
            $img_created = imagecreatefromjpeg("$pet_sireimg");
            if($img_size[2] == 3) // if png
            $img_created = imagecreatefrompng("$pet_sireimg");

            $dest_w = $new_w = $img2_param[$no_generations]['w']; // 209
            $dest_h = $new_h = $img2_param[$no_generations]['h']; // 302

            $img_ratio = imagesx($img_created) / imagesy($img_created);
            $dest_ratio = $dest_w / $dest_h;
            if ($img_ratio < $dest_ratio) {
                $new_h = $new_w / $img_ratio;
                $new_w = $new_h * $img_ratio;
            }
            else {
                $new_w = $new_h * $img_ratio;
                $new_h = $new_w / $img_ratio;
            }
            $img_created = imagescale($img_created, $new_w, $new_h);
            imagecopy($img, $img_created, 
                $img2_param[$no_generations]['x'], $img2_param[$no_generations]['y'], // dest 1128,358
                ($new_w - $dest_w) / 2, ($new_h - $dest_h) / 2, // dest offset
                $dest_w, $dest_h // width height
            );
        }
        // SIREDAM image (209x302) (1128,754)
        if ($request->input('pet_damimg_cb') == 'on') {
            $pet_damimg = 'img/no_img.jpg'; // default image
            if ($request->hasFile('pet_damimg')) {
                $pet_damimg = $request->file('pet_damimg');
            }

            $img_size = GetImageSize($pet_damimg);

            if($img_size[2] == 1) // if gif
            $img_created = imagecreatefromgif("$pet_damimg");
            if($img_size[2] == 2) // if jpg
            $img_created = imagecreatefromjpeg("$pet_damimg");
            if($img_size[2] == 3) // if png
            $img_created = imagecreatefrompng("$pet_damimg");

            $dest_w = $new_w = $img3_param[$no_generations]['w']; // 209
            $dest_h = $new_h = $img3_param[$no_generations]['h']; // 302

            $img_ratio = imagesx($img_created) / imagesy($img_created);
            $dest_ratio = $dest_w / $dest_h;
            if ($img_ratio < $dest_ratio) {
                $new_h = $new_w / $img_ratio;
                $new_w = $new_h * $img_ratio;
            }
            else {
                $new_w = $new_h * $img_ratio;
                $new_h = $new_w / $img_ratio;
            }
            $img_created = imagescale($img_created, $new_w, $new_h);
            imagecopy($img, $img_created, 
                $img3_param[$no_generations]['x'], $img3_param[$no_generations]['y'], // dest 1128,754
                ($new_w - $dest_w) / 2, ($new_h - $dest_h) / 2, // dest offset
                $dest_w, $dest_h // width height
            );
        }




        // SET NAME
        $main_name_sizes = array(
            2 => 34,
            3 => 34,
            4 => 30,
            5 => 30,
        );
        $main_name_xy = array (
            2 => array(504, 506),
            3 => array(515, 497),
            4 => array(432, 500),
            5 => array(432, 500),
        );
        $main_name_limits = array(
            2 => 500,
            3 => 500,
            4 => 350,
            5 => 300,
        );

        if ($request->input('pet_name_cb') == 'on') {
            $size = $main_name_sizes[$no_generations];
            $angle = 0;
            $txt = strtoupper($request->input('pet_name'));
            $font_path = $font_paths[0];
            $fcolor = imagecolorallocate($img, 0, 0, 0);

            $txt_dimension = imageftbbox($size, $angle, $font_path, $txt);

            while (($txt_dimension[2] - $txt_dimension[0]) > $main_name_limits[$no_generations]) {
                $size -= 5;
                $txt_dimension = imageftbbox($size, $angle, $font_path, $txt);
            }
            imagefttext(
                $img, 
                $size, 
                $angle, 
                $main_name_xy[$no_generations][0], 
                $main_name_xy[$no_generations][1] + ($txt_dimension[1] - $txt_dimension[7]), 
                $fcolor, 
                $font_path, 
                $txt
            );
        }

        // PET DETAILS
        $main_det_sizes = array(
            2 => 21,
            3 => 21,
            4 => 16,
            5 => 16,
        );
        $main_det_xy = array (
            2 => array(502, 565),
            3 => array(513, 556),
            4 => array(429, 551),
            5 => array(429, 551),
        );
        // $main_det_limits = array(
        //     2 => 500,
        //     3 => 500,
        //     4 => 350,
        //     5 => 300,
        // );
        $main_det_heights = array(
            2 => 31,
            3 => 31,
            4 => 28,
            5 => 28,
        );


        $det_arr = array();

        if ($request->input('pet_no_cb') == 'on') {
            $det_arr[0] = $request->input('pet_no');
        }
        if ($request->input('pet_birthdate_cb') == 'on') {
            $det_arr[1] = 'DOB: ' . date('F j, Y', strtotime($request->input('pet_birthdate')));
        }
        if ($request->input('pet_breed_cb') == 'on') {
            $det_arr[2] = 'BREED: ' . $request->input('pet_breed');
        }
        if ($request->input('pet_gender_cb') == 'on') {
            $det_arr[3] = 'GENDER: ' . ucwords($request->input('pet_gender'));
        }
        if ($request->input('pet_owner_cb') == 'on') {
            $det_arr[4] = 'OWNER: ' . ucwords($request->input('pet_owner'));
        }
        if ($request->input('pet_home_cb') == 'on') {
            $det_arr[5] = $home . ': ' . ucwords($request->input('pet_home'));
        }
        if ($request->input('pet_breeder_cb') == 'on') {
            $det_arr[6] = 'BREEDER: ' . ucwords($request->input('pet_breeder'));
        }


        $det_y_ctr = 1;
        foreach ($det_arr as $key => $val) {
            if (isset($val)) {
                $size = $main_det_sizes[$no_generations];
                $angle = 0;
                $txt = $val;
                $fcolor = imagecolorallocate($img, 84, 84, 84);
                $txt_dimension = imagefttext(
                    $img, 
                    $size, 
                    $angle, 
                    $main_det_xy[$no_generations][0], 
                    $main_det_xy[$no_generations][1] + ($det_y_ctr * $main_det_heights[$no_generations]), 
                    $fcolor, 
                    $font_paths[0], 
                    $txt
                );
                
                $det_y_ctr++;
            }
        }


        // GENERATION START KEYS
        $gen_start_keys = array(
            2 => 1,
            3 => 3,
            4 => 7,
            5 => 15,
        );

        // GENERATION NAME SIZES
        $gen_name_sizes = array(
            2 => array(
                24,
            ),
            3 => array(
                17,
                20,
            ),
            4 => array(
                17,
                20,
                20,
            ),
            5 => array(
                17,
                20,
                20,
                16,
            ),
        );
        // GENERATION BREED SIZES
        $gen_breed_sizes = array(
            2 => array(
                17,
            ),
            3 => array(
                12,
                14,
            ),
            4 => array(
                12,
                14,
                14,
            ),
            5 => array(
                12,
                14,
                14,
                12,
            ),
        );
        // SIRE NAME X Y
        $gen_sirename_xy = array (
            2 => array(
                array(1481, 462),
            ),
            3 => array(
                array(1173, 618),
                array(1513, 358),
                array(1513, 776),
            ),
            4 => array(
                array(873, 618),
                array(1214, 367),
                array(1214, 785),
                array(1584, 330),
                array(1584, 517),
                array(1584, 749),
                array(1584, 936),
            ),
            5 => array(
                array(818, 626),
                array(1092, 375),
                array(1092, 793),
                array(1377, 330),
                array(1377, 517),
                array(1377, 749),
                array(1377, 936),
                array(1663, 289),
                array(1663, 382),
                array(1663, 485),
                array(1663, 578),
                array(1663, 715),
                array(1663, 808),
                array(1663, 911),
                array(1663, 1004),
            ),
        );
        // DAM NAME X Y
        $gen_damname_xy = array (
            2 => array(
                array(1481, 878),
            ),
            3 => array(
                array(1173, 734),
                array(1513, 541),
                array(1513, 959),
            ),
            4 => array(
                array(873, 734),
                array(1214, 550),
                array(1214, 968),
                array(1584, 392),
                array(1584, 579),
                array(1584, 811),
                array(1584, 998),
            ),
            5 => array(
                array(818, 742),
                array(1092, 558),
                array(1092, 976),
                array(1377, 392),
                array(1377, 579),
                array(1377, 811),
                array(1377, 998),
                array(1663, 338),
                array(1663, 431),
                array(1663, 534),
                array(1663, 627),
                array(1663, 764),
                array(1663, 857),
                array(1663, 960),
                array(1663, 1053),
            ),
        );
        // GENERATION BREED Y INCREMENT
        $gen_breed_y_incs = array(
            2 => array(
                35,
            ),
            3 => array(
                25,
                29,
            ),
            4 => array(
                25,
                29,
                29,
            ),
            5 => array(
                25,
                29,
                29,
                22,
            ),
        );



        // SIRE NAME
        $name_limit = 450;
        $sire_names = $request->input('pet_sirename');

        $size_ctr = 0;
        foreach ($sire_names as $key => $row) {
            // IF KEY BREAKPOINT
            if ($gen_start_keys[$no_generations] == $key) break;

            // FOR EACH BREAKPOINT change size
            if ($key == $gen_start_keys[2] || $key == $gen_start_keys[3] || $key == $gen_start_keys[4] || $key == $gen_start_keys[5]) {
                $size_ctr++;
            }

            if (!empty($sire_names[$key])) {
                $size = $gen_name_sizes[$no_generations][$size_ctr];
                $angle = 0;
                $txt = strtoupper($sire_names[$key]);
                $font_path = $font_paths[0];
                $fcolor = imagecolorallocate($img, 0, 0, 0);

                $txt_dimension = imageftbbox($size, $angle, $font_path, $txt);

                while (($txt_dimension[2] - $txt_dimension[0]) > $name_limit) {
                    $size -= 5;
                    $txt_dimension = imageftbbox($size, $angle, $font_path, $txt);
                }
                imagefttext(
                    $img, 
                    $size, 
                    $angle, 
                    $gen_sirename_xy[$no_generations][$key][0], 
                    $gen_sirename_xy[$no_generations][$key][1] + ($txt_dimension[1] - $txt_dimension[7]), 
                    $fcolor, 
                    $font_path, 
                    $txt
                );
            }

            PetGeneration::updateOrCreate(
                [ // WHERE
                    'pet_id' => $request->input('pet_id'),
                    'pet_type' => $request->input('pet_type'),
                    'pair_no' => $key,
                ],
                [ // VALUES
                    'sire_name' => $sire_names[$key]
                ]
            );
        }

        // SIRE BREED
        $name_limit = 450;
        $sire_breeds = $request->input('pet_sirebreed');

        $size_ctr = 0;
        foreach ($sire_breeds as $key => $row) {
            // IF KEY BREAKPOINT
            if ($gen_start_keys[$no_generations] == $key) break;

            // FOR EACH BREAKPOINT change size
            if ($key == $gen_start_keys[2] || $key == $gen_start_keys[3] || $key == $gen_start_keys[4] || $key == $gen_start_keys[5]) {
                $size_ctr++;
            }

            if (!empty($sire_breeds[$key])) {
                $size = $gen_breed_sizes[$no_generations][$size_ctr];
                $angle = 0;
                $txt = 'BREED: ' . strtoupper($sire_breeds[$key]);
                $font_path = $font_paths[0];
                $fcolor = imagecolorallocate($img, 84, 84, 84);

                $txt_dimension = imageftbbox($size, $angle, $font_path, $txt);

                imagefttext(
                    $img, 
                    $size, 
                    $angle, 
                    ($gen_sirename_xy[$no_generations][$key][0]), 
                    ($gen_sirename_xy[$no_generations][$key][1] + $gen_breed_y_incs[$no_generations][$size_ctr]) + ($txt_dimension[1] - $txt_dimension[7]), 
                    $fcolor, 
                    $font_path, 
                    $txt
                );
            }

            PetGeneration::updateOrCreate(
                [ // WHERE
                    'pet_id' => $request->input('pet_id'),
                    'pet_type' => $request->input('pet_type'),
                    'pair_no' => $key,
                ],
                [ // VALUES
                    'sire_breed' => $sire_breeds[$key]
                ]
            );
        }



        // DAM NAME
        $name_limit = 450;
        $dam_names = $request->input('pet_damname');

        $size_ctr = 0;
        foreach ($dam_names as $key => $row) {
            // IF KEY BREAKPOINT
            if ($gen_start_keys[$no_generations] == $key) break;

            // FOR EACH BREAKPOINT change size
            if ($key == $gen_start_keys[2] || $key == $gen_start_keys[3] || $key == $gen_start_keys[4] || $key == $gen_start_keys[5]) {
                $size_ctr++;
            }

            if (!empty($dam_names[$key])) {
                $size = $gen_name_sizes[$no_generations][$size_ctr];
                $angle = 0;
                $txt = strtoupper($dam_names[$key]);
                $font_path = $font_paths[0];
                $fcolor = imagecolorallocate($img, 0, 0, 0);

                $txt_dimension = imageftbbox($size, $angle, $font_path, $txt);

                while (($txt_dimension[2] - $txt_dimension[0]) > $name_limit) {
                    $size -= 5;
                    $txt_dimension = imageftbbox($size, $angle, $font_path, $txt);
                }
                imagefttext(
                    $img, 
                    $size, 
                    $angle, 
                    $gen_damname_xy[$no_generations][$key][0], 
                    $gen_damname_xy[$no_generations][$key][1] + ($txt_dimension[1] - $txt_dimension[7]), 
                    $fcolor, 
                    $font_path, 
                    $txt
                );
            }

            PetGeneration::updateOrCreate(
                [ // WHERE
                    'pet_id' => $request->input('pet_id'),
                    'pet_type' => $request->input('pet_type'),
                    'pair_no' => $key,
                ],
                [ // VALUES
                    'dam_name' => $dam_names[$key]
                ]
            );
        }

        // DAM BREED
        $name_limit = 450;
        $dam_breeds = $request->input('pet_dambreed');

        $size_ctr = 0;
        foreach ($dam_breeds as $key => $row) {
            // IF KEY BREAKPOINT
            if ($gen_start_keys[$no_generations] == $key) break;

            // FOR EACH BREAKPOINT change size
            if ($key == $gen_start_keys[2] || $key == $gen_start_keys[3] || $key == $gen_start_keys[4] || $key == $gen_start_keys[5]) {
                $size_ctr++;
            }

            if (!empty($dam_breeds[$key])) {
                $size = $gen_breed_sizes[$no_generations][$size_ctr];
                $angle = 0;
                $txt = 'BREED: ' . strtoupper($dam_breeds[$key]);
                $font_path = $font_paths[0];
                $fcolor = imagecolorallocate($img, 84, 84, 84);

                $txt_dimension = imageftbbox($size, $angle, $font_path, $txt);

                imagefttext(
                    $img, 
                    $size, 
                    $angle, 
                    ($gen_damname_xy[$no_generations][$key][0]), 
                    ($gen_damname_xy[$no_generations][$key][1] + $gen_breed_y_incs[$no_generations][$size_ctr]) + ($txt_dimension[1] - $txt_dimension[7]), 
                    $fcolor, 
                    $font_path, 
                    $txt
                );
            }

            PetGeneration::updateOrCreate(
                [ // WHERE
                    'pet_id' => $request->input('pet_id'),
                    'pet_type' => $request->input('pet_type'),
                    'pair_no' => $key,
                ],
                [ // VALUES
                    'dam_breed' => $dam_breeds[$key]
                ]
            );
        }


        $watermark = 'img/certificate_templates/peds-watermark.png';
        $img_created = imagecreatefrompng("$watermark");
        $img_created = imagescale($img_created, $width, $height);
        imagecopy($img, $img_created, 
            0, 0, // dest x,y
            0, 0, // offset
            $width, $height // width height
        );


        imagepng($img);
    }

    /* AJAX FUNCTIONS */
    public function ajax_get_details_pet(Request $request)
    {
        if ($request->ajax()) {
            if (!$request->has('id') || !$request->has('type')) {
                return response()->json(0);
            }
            switch ($request->input('type')) {
                case 'dog':
                    $pet = RegistryDog::where('ID',$request->input('id'));
                    break;
                case 'cat':
                    $pet = RegistryCat::where('ID',$request->input('id'));
                    break;
                case 'rabbit':
                    $pet = RegistryRabbit::where('ID',$request->input('id'));
                    break;
                case 'bird':
                    $pet = RegistryBird::where('ID',$request->input('id'));
                    break;
                
                default:
                    $data = [
                        'status' => 'error',
                        'message' => 'Something\'s wrong! Please try again'
                    ];
                    return response()->json(0); break;
            }

            $pet_data = $pet->first()->toArray();
            $pet_data['gens'] = PetGeneration::where('pet_id', $request->input('id'))
                ->where('pet_type', $request->input('type'))
                ->get()
                ->toArray();

            return response()->json($pet_data);
        }
    }
}
