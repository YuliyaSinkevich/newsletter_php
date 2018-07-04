<?php
function Subscribers()
{
    if(isset($_POST['sub']))
    {
        $Email = $_POST['Email'];
        if(filter_var($Email, FILTER_VALIDATE_EMAIL))
        {
        $Email =trim($Email);
        $Email =stripslashes($Email);
        $SQL ="INSERT INTO `subscribers` (`subscribers_email`) VALUES ('$Email')";
        mysql_query($SQL);
        }
        else echo('<div style="position: fixed;">Не правильно введенный email!</div>');
    }
}

function MyString($text)
{
    $str = trim($text);
    $str = stripslashes($str);
    $str = htmlspecialchars($str, ENT_QUOTES);
    $str = nl2br($str);
    return $str;
}

function Newsletter()
{
if(isset($_POST['sub']))
{
    $Name = $_POST['title'];
    $Notice = $_POST['notice'];
    $Name = MyString($Name);
    $Notice =MyString($Notice);

    if(mb_strlen($Name)>0 && mb_strlen($Notice)>0)
    {
    $shablon = file_get_contents(PATH_TEMPLATE .'mail_message.tpl');
    $Id = mysql_insert_id();
    $marker=array('{NAME}','{NOTICE}','{ID}');
    $marker_info = array($Name, $Notice, $Id);
    $message = str_replace($marker, $marker_info, $shablon);
    
    $SQL = "SELECT `subscribers_email` FROM `subscribers`";
    $date = mysql_query($SQL);
    while($row = mysql_fetch_array($date))
    {
            $to = $row['subscribers_email'];
            $subject = "Новость с сайта Ptici.by";
            $subject = "=?UTF-8?B?".base64_encode($subject)."?=\n";
            $headers = "From: <postmaster@ptici.by>\r\nContent-type: text/html; charset=utf-8 \r\n";
            mail($to, $subject, $message, $headers);
    }
    }
}
}
?>