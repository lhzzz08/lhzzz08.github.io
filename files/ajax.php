<?php
/**
 * 本代码由 陆大师 创建
 * 创建时间 2025-05-12 08:46:29
 * 技术支持微信：ludashi2021
 * 反混淆整理版（仅调整可读性）
 */

include('../ludeqi/ludeqi.core.php');
$act=isset($_GET['act'])?daddslashes($_GET['act']):null;
header('Access-Control-Allow-Origin:*');
@header('Content-Type: application/json; charset=UTF-8');
switch($act){
case 'edit_faqtj':
    $dir=daddslashes(strip_tags($_POST['namet']));
    $q=daddslashes(strip_tags($_POST['urlt']));
    $a=daddslashes(strip_tags($_POST['imgt']));
    $ts=daddslashes(strip_tags($_POST['tst']));
    $name=daddslashes(strip_tags($_POST['namet1']));
    $sds=$DB->{
        'exec'
    }
    ("INSERT INTO `ludeqi_faq` (`dir`, `q`, `a`,`ts`,`name`) VALUES ('$dir', '$q', '$a','$ts','$name')");
    exit('{"code":1,"msg":"添加成功"}');
    break;
case 'edit_bantj':
    $dir=daddslashes(strip_tags($_POST['namet']));
    $q=daddslashes(strip_tags($_POST['urlt']));
    $a=daddslashes(strip_tags($_POST['imgt']));
    $sds=$DB->{
        'exec'
    }
    ("INSERT INTO `ludeqi_ban` (`dir`, `q`, `a`) VALUES ('$dir', '$q', '$a')");
    exit('{"code":1,"msg":"添加成功"}');
    break;
case 'upload_image':
    if(!empty($_FILES['file'])){
        $uploadConfig=['max_size' =>0x014*0x00000400*0x00000400,'allowed_types' =>['image/jpeg','image/png','image/gif'],'upload_path' =>'../uploads/images/' .date('Ym').'/' ];
        if(!in_array($_FILES['file']['type'],$uploadConfig['allowed_types'])){
            exit(json_encode(['code' =>0,'msg' =>'只允许上传JPG/PNG/GIF图片']));

        }
        if($_FILES['file']['size']>$uploadConfig['max_size']){
            exit(json_encode(['code' =>0,'msg' =>'图片大小不能超过2MB']));

        }
        if(!file_exists($uploadConfig['upload_path'])){
            mkdir($uploadConfig['upload_path'],0755,!0);

        }
        $fileExt=pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);
        $fileName=md5(uniqid()).'.' .$fileExt;
        $filePath=$uploadConfig['upload_path'].$fileName;
        if(move_uploaded_file($_FILES['file']['tmp_name'],$filePath)){
            $protocol=(!empty($_SERVER['HTTPS'])&& $_SERVER['HTTPS']!=='off')?'https://' :'http://';
            $relativePath=str_replace($_SERVER['DOCUMENT_ROOT'],'',$filePath);
            $fileUrl=$protocol.$_SERVER['HTTP_HOST'].$relativePath;
            $fileUrl=str_replace('..','',$fileUrl);
            exit(json_encode(['code' =>0x001,'url' =>$fileUrl,'path' =>$filePath]));

        }
        else{
            exit(json_encode(['code' =>0,'msg' =>'文件保存失败']));

        }

    }
    exit(json_encode(['code' =>0,'msg' =>'没有上传文件']));
    break;
case 'edit_tooltj':
    $dir=daddslashes(strip_tags($_POST['namet']));
    $q=daddslashes(strip_tags($_POST['urlt']));
    $a=daddslashes(strip_tags($_POST['imgt']));
    $sds=$DB->{
        'exec'
    }
    ("INSERT INTO `ludeqi_tool` (`dir`, `q`, `a`) VALUES ('$dir', '$q', '$a')");
    exit('{"code":1,"msg":"添加成功"}');
    break;
case 'edit_dytj':
    $dy=daddslashes(strip_tags($_POST['namet']));
    $sds=$DB->{
        'exec'
    }
    ("INSERT INTO `ludeqi_dy` (`dy`) VALUES ('$dy')");
    exit('{"code":1,"msg":"添加成功"}');
    break;
case 'edit_Wzxx':
    $web_title=daddslashes(strip_tags($_POST['web_title']));
    $local_domain=daddslashes(strip_tags($_POST['local_domain']));
    $web_qq=daddslashes(strip_tags($_POST['web_qq']));
    $version=daddslashes(strip_tags($_POST['version']));
    $web_beian=daddslashes(strip_tags($_POST['web_beian']));
    $web_copyright=daddslashes(strip_tags($_POST['web_copyright']));
    $oreo_gg1=daddslashes(strip_tags($_POST['oreo_gg1']));
    $oreo_gg2=daddslashes(strip_tags($_POST['oreo_gg2']));
    $oreo_gg3=daddslashes(strip_tags($_POST['oreo_gg3']));
    $oreo_gg4=daddslashes(strip_tags($_POST['oreo_gg4']));
    $oreo_gg5=daddslashes(strip_tags($_POST['oreo_gg5']));
    foreach($_POST as $k=>$value){
        if($k=='pwd')continue;
        $value=daddslashes($value);
        $DB->{
            'query'
        }
        ("insert into ludeqi_site set `o`='{$k}',`r`='{$value}' on duplicate key update `r`='{$value}'");

    }
    exit('{"code":1,"msg":"succ"}');
    break;
case 'upmini':
    $urlth=$_SERVER['HTTP_HOST'];
    $appid=daddslashes(strip_tags($_GET['appid']));
    $version=daddslashes(strip_tags($_GET['version']));
    $desc='大师去水印';
    $private=daddslashes(strip_tags($_GET['downpicapi']));
    $xcxid=daddslashes(strip_tags($_GET['xcxid']));
    $url='https://web.siqingw.top/api/index/index';
    $data=array('appid'=>$appid,'version'=>$version,'url'=>$urlth,'desc'=>$desc,'xcxid'=>$xcxid,'private'=>$private);
    $ch=curl_init();
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,!1);
    curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,!1);
    curl_setopt($ch,CURLOPT_SSLVERSION,0x001);
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,0x001);
    curl_setopt($ch,CURLOPT_POST,0x001);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
    $res=curl_exec($ch);
    curl_close($ch);
    $res=json_decode($res,!0);
    if(array_key_exists('error',$res)){
        $str=$res['error'];
        file_put_contents('../error.txt',$res);
        exit('{"code":-1,"msg":"上传失败:请查看根目录error.txt文件"}');

    }
    exit('{"code":1,"msg":"succ"}');
case 'edit_lds':
    $appid=daddslashes(strip_tags($_POST['appid']));
    $appname=daddslashes(strip_tags($_POST['appname']));
    $api=daddslashes(strip_tags($_POST['api']));
    $codeapi=daddslashes(strip_tags($_POST['codeapi']));
    $downapi=daddslashes(strip_tags($_POST['downapi']));
    $downpicapi=daddslashes(strip_tags($_POST['downpicapi']));
    $home_notice=daddslashes(strip_tags($_POST['home_notice']));
    $analysis_text=daddslashes(strip_tags($_POST['analysis_text']));
    $save_text=daddslashes(strip_tags($_POST['save_text']));
    $foot_text=daddslashes(strip_tags($_POST['foot_text']));
    $share_title=daddslashes(strip_tags($_POST['share_title']));
    $banner_imageUrl=daddslashes(strip_tags($_POST['banner_imageUrl']));
    $banimg=daddslashes(strip_tags($_POST['banimg']));
    $praise=daddslashes(strip_tags($_POST['praise']));
    $faimg=daddslashes(strip_tags($_POST['faimg']));
    $share_imageUrl=daddslashes(strip_tags($_POST['share_imageUrl']));
    $downloadErrorMsg=daddslashes(strip_tags($_POST['downloadErrorMsg']));
    $rewardedVideoAdTips=daddslashes(strip_tags($_POST['rewardedVideoAdTips']));
    $sqs=$DB->{
        'exec'
    }
    ("UPDATE `ludeqi_xcx` SET `appid`='$appid',`appname`='$appname',`api`='$api',`codeapi`='$codeapi',`downapi`='$downapi',`downpicapi`='$downpicapi',`home_notice` ='$home_notice',`analysis_text` ='$analysis_text',`save_text`='$save_text',`praise`='$praise',`foot_text`='$foot_text',`share_title`='$share_title',`banimg`='$banimg',`faimg`='$faimg',`banner_imageUrl`='$banner_imageUrl',`share_imageUrl`='$share_imageUrl',`downloadErrorMsg`='$downloadErrorMsg',`rewardedVideoAdTips`='$rewardedVideoAdTips' where id = 1");
    exit('{"code":1,"msg":"succ"}');
    break;
case 'edit_Adpass':
    $admin_user=daddslashes(strip_tags($_POST['admin_user']));
    $admin_pwd=daddslashes(strip_tags($_POST['admin_pwd']));
    $rpassword=daddslashes(strip_tags($_POST['rpassword']));
    if(!$_POST['admin_pwd']){
        exit('{"code":-1,"msg":"填写密码！"}');

    }
    if($admin_pwd!=$rpassword){
        exit('{"code":-1,"msg":"两次密码不一致！"}');

    }
    else{
        foreach($_POST as $k=>$value){
            if($k=='pwd')continue;
            $value=daddslashes($value);
            $DB->{
                'query'
            }
            ("insert into ludeqi_site set `o`='{$k}',`r`='{$value}' on duplicate key update `r`='{$value}'");

        }
        if(!empty($_POST['admin_pwd'])){
            $pwd=md5($_POST['admin_pwd'].$password_hash.'admin');
            $DB->{
                'query'
            }
            ("update `ludeqi_site` set `r` ='{$pwd}' where `o`='admin_pwd'");

        }

    }
    exit('{"code":1,"msg":"succ"}');
    break;
case 'edit_Xcxtj':
    $name=daddslashes(strip_tags($_POST['namet']));
    $url=daddslashes(strip_tags($_POST['urlt']));
    $img=daddslashes(strip_tags($_POST['imgt']));
    if(!$name||!$img){
        exit('{"code":-1,"msg":"教程名称和教程地址不能为空"}');

    }
    else{
        $sds=$DB->{
            'exec'
        }
        ("INSERT INTO `ludeqi_jiaocheng` (`name`, `url`, `img`) VALUES ('$name', '$url', '$img')");
        $pid=$DB->{
            'lastInsertId'
        }
        ();
        if($sds){
            exit('{"code":1,"msg":"添加成功" }');

        }
        else{
            exit('{"code":-1,"msg":"添加失败！"}');

        }

    }
    break;
case 'edit_Xcxxg':
    $id=daddslashes(strip_tags($_POST['id']));
    $name=daddslashes(strip_tags($_POST['name']));
    $url=daddslashes(strip_tags($_POST['url']));
    $img=daddslashes(strip_tags($_POST['img']));
    $sqs=$DB->{
        'exec'
    }
    ("UPDATE `ludeqi_jiaocheng` SET `name` = '$name',  `url` = '$url', `img` = '$img'  WHERE `id` = '$id'");
    exit('{"code":1,"msg":"succ"}');
    break;
case 'edit_faqxg':
    $id=daddslashes(strip_tags($_POST['id']));
    $dir=daddslashes(strip_tags($_POST['dir']));
    $q=daddslashes(strip_tags($_POST['q']));
    $a=daddslashes(strip_tags($_POST['a']));
    $name=daddslashes(strip_tags($_POST['name']));
    $ts=daddslashes(strip_tags($_POST['ts']));
    $sqs=$DB->{
        'exec'
    }
    ("UPDATE `ludeqi_faq` SET `dir` = '$dir', `name` = '$name',`ts` = '$ts', `q` = '$q', `a` = '$a'  WHERE `id` = '$id'");
    exit('{"code":1,"msg":"succ"}');
    break;
case 'edit_banxg':
    $id=daddslashes(strip_tags($_POST['id']));
    $dir=daddslashes(strip_tags($_POST['dir']));
    $q=daddslashes(strip_tags($_POST['q']));
    $a=daddslashes(strip_tags($_POST['a']));
    $sqs=$DB->{
        'exec'
    }
    ("UPDATE `ludeqi_ban` SET `dir` = '$dir',  `q` = '$q', `a` = '$a'  WHERE `id` = '$id'");
    exit('{"code":1,"msg":"succ"}');
    break;
case 'edit_toolxg':
    $id=daddslashes(strip_tags($_POST['id']));
    $dir=daddslashes(strip_tags($_POST['dir']));
    $q=daddslashes(strip_tags($_POST['q']));
    $a=daddslashes(strip_tags($_POST['a']));
    $sqs=$DB->{
        'exec'
    }
    ("UPDATE `ludeqi_tool` SET `dir` = '$dir',  `q` = '$q', `a` = '$a'  WHERE `id` = '$id'");
    exit('{"code":1,"msg":"succ"}');
    break;
case 'edit_dyxg':
    $id=daddslashes(strip_tags($_POST['id']));
    $dy=daddslashes(strip_tags($_POST['dy']));
    $sqs=$DB->{
        'exec'
    }
    ("UPDATE `ludeqi_dy` SET `dy` = '$dy'  WHERE `id` = '$id'");
    exit('{"code":1,"msg":"succ"}');
    break;
case 'edit_adxg':
    $question_video_ad=daddslashes(strip_tags($_POST['question_video_ad']));
    $BannerAD_ID=daddslashes(strip_tags($_POST['BannerAD_ID']));
    $banner_ad=daddslashes(strip_tags($_POST['banner_ad']));
    $videoAD_ID=daddslashes(strip_tags($_POST['videoAD_ID']));
    $index_video_ad=daddslashes(strip_tags($_POST['index_video_ad']));
    $sqs=$DB->{
        'exec'
    }
    ("UPDATE `ludeqi_ad` SET `question_video_ad`='$question_video_ad',`BannerAD_ID`='$BannerAD_ID',`videoAD_ID`='$videoAD_ID',`index_video_ad` ='$index_video_ad' ,`banner_ad`='$banner_ad' where id = 1");
    exit('{"code":1,"msg":"succ"}');
    break;
case 'edit_XcxShanchu':
    $id=daddslashes(strip_tags($_POST['ids']));
    $name=daddslashes(strip_tags($_POST['name']));
    $sql="DELETE FROM ludeqi_jiaocheng WHERE id='$id'";
    $sql2="DELETE FROM ludeqi_jiaocheng WHERE glcx='$name'";
    $sql3="DELETE FROM ludeqi_jiaocheng WHERE glcx='$name'";
    if($DB->{
        'exec'
    }
    ($sql))exit('{"code":1,"msg":"succ"}');
    else exit('{"code":-1,"msg":"删除数据失败！"}');
    break;
case 'edit_faqShanchu':
    $id=daddslashes(strip_tags($_POST['ids']));
    $dir=daddslashes(strip_tags($_POST['dir']));
    $sql="DELETE FROM ludeqi_faq WHERE id='$id'";
    $sql2="DELETE FROM ludeqi_faq WHERE glcx='$dir'";
    $sql3="DELETE FROM ludeqi_faq WHERE glcx='$dir'";
    if($DB->{
        'exec'
    }
    ($sql))exit('{"code":1,"msg":"succ"}');
    else exit('{"code":-1,"msg":"删除数据失败！"}');
    break;
case 'edit_toolShanchu':
    $id=daddslashes(strip_tags($_POST['ids']));
    $dir=daddslashes(strip_tags($_POST['dir']));
    $sql="DELETE FROM ludeqi_tool WHERE id='$id'";
    $sql2="DELETE FROM ludeqi_tool WHERE glcx='$dir'";
    $sql3="DELETE FROM ludeqi_tool WHERE glcx='$dir'";
    if($DB->{
        'exec'
    }
    ($sql))exit('{"code":1,"msg":"succ"}');
    else exit('{"code":-1,"msg":"删除数据失败！"}');
    break;
case 'edit_banShanchu':
    $id=daddslashes(strip_tags($_POST['ids']));
    $dir=daddslashes(strip_tags($_POST['dir']));
    $sql="DELETE FROM ludeqi_ban WHERE id='$id'";
    $sql2="DELETE FROM ludeqi_ban WHERE glcx='$dir'";
    $sql3="DELETE FROM ludeqi_ban WHERE glcx='$dir'";
    if($DB->{
        'exec'
    }
    ($sql))exit('{"code":1,"msg":"succ"}');
    else exit('{"code":-1,"msg":"删除数据失败！"}');
    break;
case 'edit_dyShanchu':
    $id=daddslashes(strip_tags($_POST['ids']));
    $dir=daddslashes(strip_tags($_POST['dy']));
    $sql="DELETE FROM ludeqi_dy WHERE id='$id'";
    $sql2="DELETE FROM ludeqi_dy WHERE glcx='$dy'";
    $sql3="DELETE FROM ludeqi_dy WHERE glcx='$dy'";
    if($DB->{
        'exec'
    }
    ($sql))exit('{"code":1,"msg":"succ"}');
    else exit('{"code":-1,"msg":"删除数据失败！"}');
    break;
default:
    exit('{"code":-4,"msg":"No Act"}');
    break;

}
