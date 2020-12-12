<?php
    function tagReader($file)
    {
        $id3v23 = array("TIT2","TALB","TPE1","TRCK","TDRC","TLEN","USLT","TCON","APIC");
        $id3v22 = array("TT2","TAL","TP1","TRK","TYE","TLE","ULT","TCO");
        $fsize = filesize($file);
        $fd = fopen($file,"r");
        $tag = fread($fd,$fsize);
        $tmp = "";
        fclose($fd);
        if (substr($tag,0,3) == "ID3")
        {
            $result['FileName'] = $file;
            $result['TAG'] = substr($tag,0,3);
            $result['Version'] = hexdec(bin2hex(substr($tag,3,1))).".".hexdec(bin2hex(substr($tag,4,1)));
        }
        if($result['Version'] == "4.0" || $result['Version'] == "3.0" || $result['Version'] == "2.0")
        {
            for ($i=0;$i<count($id3v23);$i++)
            {
                if (strpos($tag,$id3v23[$i].chr(0))!= FALSE)
                {
                    $pos = strpos($tag, $id3v23[$i].chr(0));
                    $len = hexdec(bin2hex(substr($tag,($pos+5),3)));
                    $data = substr($tag, $pos, 9+$len);
                    for ($a=0;$a<strlen($data);$a++)
                    {
                        $char = substr($data,$a,1);
                        if($char >= " " && $char <= "~")
                        {
                            $tmp.=$char;
                        }
                    }
                    if(substr($tmp,0,4) == "TIT2") $result['Title'] = substr($tmp,4);
                    if(substr($tmp,0,4) == "TALB") $result['Album'] = substr($tmp,4);
                    if(substr($tmp,0,4) == "TPE1") $result['Artist'] = substr($tmp,4);
                    if(substr($tmp,0,4) == "TRCK") $result['TrackNo'] = substr($tmp,4);
                    if(substr($tmp,0,4) == "TDRC") $result['Year'] = substr($tmp,4);
                    if(substr($tmp,0,4) == "TLEN") $result['Length'] = substr($tmp,4);
                    if(substr($tmp,0,4) == "USLT") $result['Lyric'] = substr($tmp,7);
                    if(substr($tmp,0,4) == "TCON") $result['Genre'] = substr($tmp,4);
                    // if(substr($tmp,0,4) == "APIC") $result['AttachedPicture'] = substr($tmp,4);
                    $tmp = "";
                }
            }
        }
        if($result['Version'] == "2.0")
        {
            for ($i=0;$i<count($id3v22);$i++)
            {
                if (strpos($tag,$id3v22[$i].chr(0))!= FALSE)
                {
                    $pos = strpos($tag, $id3v22[$i].chr(0));
                    $len = hexdec(bin2hex(substr($tag,($pos+3),3)));
                    $data = substr($tag, $pos, 6+$len);
                    for ($a=0;$a<strlen($data);$a++)
                    {
                        $char = substr($data,$a,1);
                        if($char >= " " && $char <= "~")
                        {
                            $tmp.=$char;
                        }
                    }
                    if(substr($tmp,0,3) == "TT2") $result['Title'] = substr($tmp,3);
                    if(substr($tmp,0,3) == "TAL") $result['Album'] = substr($tmp,3);
                    if(substr($tmp,0,3) == "TP1") $result['Artist'] = substr($tmp,3);
                    if(substr($tmp,0,3) == "TRK") $result['TrackNo'] = substr($tmp,3);
                    if(substr($tmp,0,3) == "TYE") $result['Year'] = substr($tmp,3);
                    if(substr($tmp,0,3) == "TLE") $result['Length'] = substr($tmp,3);
                    if(substr($tmp,0,3) == "ULT") $result['Lyric'] = substr($tmp,6);
                    if(substr($tmp,0,3) == "TCO") $result['Genre'] = substr($tmp,3);
                    // if(substr($tmp,0,3) == "PIC") $result['AttachedPicture'] = base64_encode(substr($tmp,3));
                    $tmp = "";
                }
            }
        }
        return $result;
    }
