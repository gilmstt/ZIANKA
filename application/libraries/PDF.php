<?php
include_once('fpdf/fpdf.php');
//funciones para WriteHTML
    //function hex2dec
    //returns an associative array (keys: R,G,B) from
    //a hex html code (e.g. #3FE5AA)
    function hex2dec($couleur = "#000000"){
        $R = substr($couleur, 1, 2);
        $rouge = hexdec($R);
        $V = substr($couleur, 3, 2);
        $vert = hexdec($V);
        $B = substr($couleur, 5, 2);
        $bleu = hexdec($B);
        $tbl_couleur = array();
        $tbl_couleur['R']=$rouge;
        $tbl_couleur['V']=$vert;
        $tbl_couleur['B']=$bleu;
        return $tbl_couleur;
    }

    //conversion pixel -> millimeter at 72 dpi
    function px2mm($px){
        return $px*25.4/72;
    }

    function txtentities($html){
        $trans = get_html_translation_table(HTML_ENTITIES);
        $trans = array_flip($trans);
        return strtr($html, $trans);
    }
class PDF extends FPDF{
 //variables of html parser
 protected $B=0;
 protected $I=0;
 protected $U=0;
 protected $HREF='';
 /* protected $fontList;
 protected $issetfont;
 protected $issetcolor; */

    function designUp($espejo = 0){
       // $this->Rect( (13 + $espejo), 13, 15, 10); //Marco exterior
        $this->Image(base_url()."assets/img/logo1.png",35,7,28);
        $this->SetDrawColor(84,109,175);
        $this->SetTextColor(6,6,6);
        
                    
        //Imagen de expo
        //$this->Image('../images/expo.jpg', (18 + $espejo), 65, 80 ,45);
 
    }
 
    //************************  funciones de clase WRITEHTML**************************/

		function WriteHTML($html)
		{
			//HTML parser
			$html=strip_tags($html,"<b><u><i><a><img><p><br><strong><em><font><tr><blockquote>"); //supprime tous les tags sauf ceux reconnus
			$html=str_replace("\n",' ',$html); //remplace retour à la ligne par un espace
			$a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE); //éclate la chaîne avec les balises
			foreach($a as $i=>$e)
			{
				if($i%2==0)
				{
					//Text
					if($this->HREF)
							$this->PutLink($this->HREF,$e);
					else
							$this->Write(5,stripslashes(txtentities($e)));
				}
				else
				{
					//Tag
					if($e[0]=='/')
							$this->CloseTag(strtoupper(substr($e,1)));
					else
					{
							//Extract attributes
							$a2=explode(' ',$e);
							$tag=strtoupper(array_shift($a2));
							$attr=array();
							foreach($a2 as $v)
							{
								if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
									$attr[strtoupper($a3[1])]=$a3[2];
							}
							$this->OpenTag($tag,$attr);
					}
				}
			}
		}

		function OpenTag($tag, $attr)
		{
			//Opening tag
			switch($tag){
				case 'STRONG':
					$this->SetStyle('B',true);
					break;
				case 'EM':
					$this->SetStyle('I',true);
					break;
				case 'B':
				case 'I':
				case 'U':
					$this->SetStyle($tag,true);
					break;
				case 'A':
					$this->HREF=$attr['HREF'];
					break;
				case 'IMG':
					if(isset($attr['SRC']) && (isset($attr['WIDTH']) || isset($attr['HEIGHT']))) {
							if(!isset($attr['WIDTH']))
								$attr['WIDTH'] = 0;
							if(!isset($attr['HEIGHT']))
								$attr['HEIGHT'] = 0;
							$this->Image($attr['SRC'], $this->GetX(), $this->GetY(), px2mm($attr['WIDTH']), px2mm($attr['HEIGHT']));
					}
					break;
				case 'TR':
				case 'BLOCKQUOTE':
				case 'BR':
					$this->Ln(5);
					break;
				case 'P':
					$this->Ln(10);
					break;
				case 'FONT':
					if (isset($attr['COLOR']) && $attr['COLOR']!='') {
							$coul=hex2dec($attr['COLOR']);
							$this->SetTextColor($coul['R'],$coul['V'],$coul['B']);
							$this->issetcolor=true;
					}
					if (isset($attr['FACE']) && in_array(strtolower($attr['FACE']), $this->fontlist)) {
							$this->SetFont(strtolower($attr['FACE']));
							$this->issetfont=true;
					}
					break;
			}
		}

		function CloseTag($tag)
		{
			//Closing tag
			if($tag=='STRONG')
				$tag='B';
			if($tag=='EM')
				$tag='I';
			if($tag=='B' || $tag=='I' || $tag=='U')
				$this->SetStyle($tag,false);
			if($tag=='A')
				$this->HREF='';
			if($tag=='FONT'){
				if ($this->issetcolor==true) {
					$this->SetTextColor(0);
				}
				if ($this->issetfont) {
					$this->SetFont('arial');
					$this->issetfont=false;
				}
			}
		}

		function SetStyle($tag, $enable)
		{
			//Modify style and select corresponding font
			$this->$tag+=($enable ? 1 : -1);
			$style='';
			foreach(array('B','I','U') as $s)
			{
				if($this->$s>0)
					$style.=$s;
			}
			$this->SetFont('',$style);
		}

		function PutLink($URL, $txt)
		{
			//Put a hyperlink
			$this->SetTextColor(0,0,255);
			$this->SetStyle('U',true);
			$this->Write(5,$txt,$URL);
			$this->SetStyle('U',false);
			$this->SetTextColor(0);
        }
        function WordWrap(&$text, $maxwidth)
        {
            $text = trim($text);
            if ($text==='')
                return 0;
            $space = $this->GetStringWidth(' ');
            $lines = explode("\n", $text);
            $text = '';
            $count = 0;

            foreach ($lines as $line)
            {
                $words = preg_split('/ +/', $line);
                $width = 0;

                foreach ($words as $word)
                {
                    $wordwidth = $this->GetStringWidth($word);
                    if ($wordwidth > $maxwidth)
                    {
                        // Word is too long, we cut it
                        for($i=0; $i<strlen($word); $i++)
                        {
                            $wordwidth = $this->GetStringWidth(substr($word, $i, 1));
                            if($width + $wordwidth <= $maxwidth)
                            {
                                $width += $wordwidth;
                                $text .= substr($word, $i, 1);
                            }
                            else
                            {
                                $width = $wordwidth;
                                $text = rtrim($text)."\n".substr($word, $i, 1);
                                $count++;
                            }
                        }
                    }
                    elseif($width + $wordwidth <= $maxwidth)
                    {
                        $width += $wordwidth + $space;
                        $text .= $word.' ';
                    }
                    else
                    {
                        $width = $wordwidth + $space;
                        $text = rtrim($text)."\n".$word.' ';
                        $count++;
                    }
                }
                $text = rtrim($text)."\n";
                $count++;
            }
            $text = rtrim($text);
            return $count;
        }

}//fin clase PDF
?>