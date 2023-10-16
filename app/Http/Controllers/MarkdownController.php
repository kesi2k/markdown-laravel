<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MarkdownController extends Controller
{
    // Get markdown create form
    public function create(){
        return view('markdown.create');
	}

    public $htmlFormatOpen = [
        0 => "<p>",
        1 => "<h1>",
        2 => "<h2>",
        3 => "<h3>",
        4 => "<h4>",
        5 => "<h5>",
        6 => "<h6>",
        7 => "<a href=\"",
        8 => 'Empty'
    ];

    public $htmlFormatClose = [
        0 => "</p>",
        1 => "</h1>",
        2 => "</h2>",
        3 => "</h3>",
        4 => "</h4>",
        5 => "</h5>",
        6 => "</h6>",
        7 => "\"></a>",
        8 => 'Empty'
    ];

    public function post(Request $request){
        $markDownData = nl2br($request->message);
        $arrayOfLines = explode("\n", $markDownData);

        // print_r($markDownData);

        $htmlTagIndex=[];
        $charsRemoved = [];
        
        // Look for markdown chars to convert to HTML
        foreach ($arrayOfLines as $line) {
            $resultFirstChar = $this->convert($line);
            array_push($htmlTagIndex, $resultFirstChar);   
        }


        // Remove chars from markdown lines
        foreach ($arrayOfLines as $line) {
            $charactersToRemove = array("#", "<br />");
            $newString = str_replace($charactersToRemove, "", $line);
            $lineTrimmed = trim($newString);
            array_push($charsRemoved, $lineTrimmed);   
        } 
   
        
        // Index to keep track of first and last line when adding tags
        $index = 0;
        $length = count($htmlTagIndex);
        foreach ($htmlTagIndex as $key => $val) {
            // First line
            if($index === 0){

                // openTag
                $htmlLine = $this->openTag($val, $key, $charsRemoved);
                $charsRemoved[$key] = $htmlLine;

                // if first line is also last, close tag
                if($index === $length - 1){
                    $htmlLine = $this->closeTag($val, $key, $charsRemoved);
                    $charsRemoved[$key] = $htmlLine;
                } else{
                    // else check next line
                    if($htmlTagIndex[$key + 1] !==  $htmlTagIndex[$key]){
                        $htmlLine = $this->closeTag($val, $key, $charsRemoved);
                        $charsRemoved[$key] = $htmlLine;
                    }
                }

            }elseif($index >= 1 && $index < $length - 1){
                 // Middle

                // If tag before not equal, open tag
                if($htmlTagIndex[$key - 1] !==  $htmlTagIndex[$key]){
                    $htmlLine = $this->openTag($val, $key, $charsRemoved);
                    $charsRemoved[$key] = $htmlLine;
                }

                // If tag after not equal close the html tag.
                if($htmlTagIndex[$key + 1] !==  $htmlTagIndex[$key]){
                    $htmlLine = $this->closeTag($val, $key, $charsRemoved);
                    $charsRemoved[$key] = $htmlLine;
                }

            } else {
                // If tag before not equal, open tag
                if($htmlTagIndex[$key - 1] !==  $htmlTagIndex[$key]){
                    $htmlLine = $this->openTag($val, $key, $charsRemoved);
                    $charsRemoved[$key] = $htmlLine;
                }

                // Last line, close tag
                $htmlLine = $this->closeTag($val, $key, $charsRemoved);
                $charsRemoved[$key] = $htmlLine;
            }
            $index++;
        }


        // Check for link
        foreach ($charsRemoved as $key => $line) {
            $charSearch = "[";
            
            if (strpos($line, $charSearch) !== false) {
                // Get chars bet '[' and ']'
                $startPos = strpos($line, "[") + 1;
                $endPos = strpos($line, "]");
                $length = $endPos - $startPos;
                $linkStr = substr($line, $startPos, $length);

                $linkTextRemoved = str_replace(['(',], $this->htmlFormatOpen[7], $line);
                $linkTextRemoved = str_replace([')'], $this->htmlFormatClose[7], $linkTextRemoved);

                // Remove chars between "[" and "]"
                $pattern = "/\[[^\]]*\]/";
                $linkTextRemoved = preg_replace($pattern, '', $linkTextRemoved);

                // Get position of '>'. Insert link info there
                $endOpenAtag = strpos($linkTextRemoved, "\">") + 2;
                $finalHtmlLine = substr_replace($linkTextRemoved, $linkStr, $endOpenAtag, 0);

                $charsRemoved[$key] = $finalHtmlLine;
            }
        }


        $variables = [
            'markDownData' => $markDownData,
            'charsRemoved' => $charsRemoved
        ];

        // print_r($variables);

        return view('markdown.markdown', $variables);

    }


    public function convert($arrLineToConvert){
        $firstChar = substr($arrLineToConvert, 0, 1);

        if (ctype_alpha($firstChar)){
            return 0;
        } elseif ($firstChar === '#') {
            $count = substr_count($arrLineToConvert, '#');
            return $count;
        } {
            return 8;
        }
    }

    public function openTag($val, $key, $charsRemoved){
        return $this->htmlFormatOpen[$val] . $charsRemoved[$key];
    }

    public function closeTag($val, $key, $charsRemoved){
        return $charsRemoved[$key] . $this->htmlFormatClose[$val];
    }

}
