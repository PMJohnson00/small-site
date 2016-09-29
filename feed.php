<?php
// NEW RSS FEED CODE
 // create a new rss-feed.php for each blog template and feed variety
 // this is to simplify the rss script and to remove possibility of being exploited for external use
 // template is part of this file
 // any variations to feed must be coded here
 // feed can be displayed using ajax (see /js/scripts.js for pertinent ajax code)
 
 // select feed and number of entries to view
	$xml=("http://855webmaster.com/blog/feed/");
	$itemNumber = 3;
	$descTruncate = 200;  
	$titleTruncate = 70; 
	
// function to truncate to set number of letters to nearest space
if (!function_exists('tokenTruncate')) {
	function tokenTruncate($string, $your_desired_width) {
	  if (strlen($string) <= $your_desired_width ) { return $string; }
	  $parts = preg_split('/([\s\n\r]+)/', $string, null, PREG_SPLIT_DELIM_CAPTURE);
	  $parts_count = count($parts);
	
	  $length = 0;
	  $last_part = 0;
	  for (; $last_part < $parts_count; ++$last_part) {
		$length += strlen($parts[$last_part]);
		if ($length > $your_desired_width) { break; }
	  }
	
	  return implode(array_slice($parts, 0, $last_part)).'&hellip;';
	}
}

 //get and output "<item>" elements
	 $xmlDoc = new DOMDocument();
	 $xmlDoc->load($xml);
	 $itemNumbermod = $itemNumber-1;
	 $feed_Items = $xmlDoc->getElementsByTagName('item')->length;
	 if ($feed_Items < $itemNumber) { $itemNumber = $feed_Items;}
	 $x=$xmlDoc->getElementsByTagName('item');
	 for ($i=0; $i<=$itemNumber-1; $i++) {
		 // TITLE full and truncated both available
	   $item_title=$x->item($i)->getElementsByTagName('title') ->item(0)->childNodes->item(0)->nodeValue;
	   $trunk_title = tokenTruncate($item_title, $titleTruncate); 
	   	 // DATE
	   $item_date=$x->item($i)->getElementsByTagName('pubDate') ->item(0)->childNodes->item(0)->nodeValue;
	   $unix_date = strtotime($item_date);
	   $the_date = date('F j, Y',$unix_date); // mod date format here
	     // LINK
	   $item_link=$x->item($i)->getElementsByTagName('link') ->item(0)->childNodes->item(0)->nodeValue;
	   //$item_enclosure=$x->item($i)->getElementsByTagName('enclosure')  ->item(0)->getAttribute('url');
	     // DESCRIPTION full and truncated both available
	    $item_desc=$x->item($i)->getElementsByTagName('description')  ->item(0)->childNodes->item(0)->nodeValue;
		$trunk_desc = tokenTruncate($item_desc, $descTruncate); ?>

<?php // START feed template  ?>
<div class="bl"><p><span><?php echo $the_date; ?></span><br><a href="<?php echo $item_link; ?>" title="<?php echo $item_title; ?>" target="_blank"><strong> <?php echo $trunk_title; ?></strong></a></p></div>
<?php // END feed template ?>
<?php  } ?>
<div class="cl"></div>