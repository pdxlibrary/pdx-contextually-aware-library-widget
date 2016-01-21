<?php

/*

Portland State University Library - Contextually-Aware Library Widget

Copyright (c) 2012 Portland State University Library

Permission is hereby granted, free of charge, to any person obtaining a copy of this software 
and associated documentation files (the "Software"), to deal in the Software without restriction, 
including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, 
and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, 
subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial 
portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT 
LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN 
NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE 
SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

*/


if(USE_CACHE)
{
	if(!strcmp(CACHE_TYPE,"database"))
	{
		require_once("includes/connect.php");
		require_once("includes/mysql_functions.php");
	}
}


function api_search($query_string)
{
	// print("search: $query_string<br>\n");
	$query_string = urldecode($query_string);
	
	if(USE_CACHE)
	{
		if(!strcmp(CACHE_TYPE,"database"))
		{
			//print("<br>query: $query_string<br>\n");
			$select = "select * from cache where query_string like '".$query_string."' and date_added > '".CACHE_CUTOFF."' and active like '1' limit 1";
			//print("select: $select<br>\n");
			$res = mysql_query($select);
			if(mysql_num_rows($res)==1)
			{
				// use the cached version
				$results = mysql_fetch_object($res);
				//print("document.write('<!-- from cache ".date("Y-m-d H:i:s",strtotime($results->date_added))." -->');");
				return($results->result);
			}
		}
		else if(!strcmp(CACHE_TYPE,"memcache"))
		{
			$memcache = @memcache_connect(CACHE_SERVER,CACHE_PORT);
			
			if($memcache)
			{
				$result = array();
				$result = $memcache->get($query_string);
				if($result !== false)
				{
					// print("<!-- $query_string from cache -->");
					return($result);
				}
			}
		}
	}

	// if cache is off or no fresh cache version
	
	// translate search term to tag id
	// TODO: load this list using LibGuides API
	// https://pdx.libapps.com/libguides/widgets.php?action=1
	$tags = "199021=accounting|198712=actg|198782=administration of justice|198904=africa|198899=african american|198900=african american studies|198798=aging|198772=america|198754=american|198755=american history|198657=analytic methods|198695=anth|198662=anth 311|199016=anth 325|199013=anth 325-001|199014=anth 325u|199015=anth 325u-001|198889=anth 357|198882=anth 357-001|198883=anth 357u|198884=anth 357u-001|199103=anth 361|199100=anth 361u|199099=anth 365|199097=anth 365u|198885=anth 399|198886=anth 399-001|198918=anth 428|198917=anth 528|198661=anth311u|199101=anth361|199102=anth361u|198692=anth412|198693=anth412/512|198694=anth512|198887=anthropology|198974=applied linguistics|198971=appling|198802=arch|198888=archaeology|198804=arh|198803=art|198700=audiology|198707=ba|198852=ba 101|198851=ba 301|198850=ba 311|198846=ba 311-ol1|199007=ba 385-007|198925=ba 495|198719=bi|199049=bible|199045=biblical|198963=biostatistics|198901=black studies|198902=blacks|198903=bst|198691=business|199005=business environment|199006=business ethics|199031=career|198778=ccj|199096=ccj 380|198731=ce|199093=cf|198696=cfs|199034=cfs 494|198720=ch|198665=challenge|198911=chicano|198905=chicano latino studies|198906=chla|199086=chla 450u|198839=ci|198728=civil engineering|198952=com|198929=comm|198930=comm 100|198931=comm 200|198932=comm 311|198933=comm 312u|198934=comm 313u|198935=comm 314u|198936=comm 316|198937=comm 318u|198938=comm 336|198939=comm 337u|198940=comm 389u|198941=comm 399|198942=comm 409|198943=comm 410|198944=comm 412|198945=comm 415u|198946=comm 418|198947=comm 472|198948=comm 487|198949=comm 503|199066=commodity chain|198950=communication|198951=communication studies|199073=community development|198640=community health|198668=community nutrition|198706=company|198646=comparative politics|198736=computer engineering|198740=computer science|198898=conflict resolution|198716=consumer|198779=corrections|198840=coun|199104=course|198897=cr|198780=criminal justice|198781=criminology|198737=cs|198875=dark ages|198717=demographics|198704=documents|198801=ec|198732=ece|198677=ecofeminist|198800=economics|198810=ed|198641=elections|198733=electrical &amp; computer engineering|198734=electrical engineering|198735=electronics engineering|198842=elp|198680=eng|199090=eng 300-003|198679=eng 300-005|198975=eng 500|198729=engineering|198752=engineering management|198870=england|198805=english|198923=entrepreneurship|198730=environmental engineering|198953=environmental health|199042=environmental law|199002=environmental science|198954=epidemiology|198726=esm|198724=esr|198753=etm|198859=europe|198860=european history|198655=evaluation|198789=exercise|198690=faculty|199046=feminist|198807=film|198708=fin|199019=finance|198920=fl 560|198919=fl560|199113=foreign|198861=france|199109=french|198721=g|199047=gender|198722=geog|198862=germany|198790=gerontology|199062=globalization|198663=grant|198664=grant high|198660=health|198658=health administration|198791=health education|198792=health promotion|198907=hispanic|198878=historiography|198756=history|198969=hon 101|198964=hon 102|198965=hon 103|198966=hon 203|198967=hon 403|198968=honors|198757=hst|198758=hst 201|198759=hst 202|198876=hst 300|198760=hst 328|198761=hst 341|198762=hst 343|198863=hst 351|198871=hst 355|198763=hst 399-jkk|198764=hst 407g|198765=hst 407h|198864=hst 407i|198766=hst 429-dah|198865=hst 460-kxm|198767=hst 507g|198768=hst 507h|198866=hst 507i|198769=hst 529-dah|198867=hst 560-kxm|199085=human|198872=iberia|198921=ielp|199095=indigenous nations|199094=indigenous nations studies|198713=industry|198880=innovation|198845=international business|198955=international health|199039=international law|199051=intl|199091=intl 226c|198896=intl 247|198890=intl 247c|198891=intl 331|198892=intl 332|198893=intl 332u|198894=intl 399-001|198709=isqa|198858=jewish|198854=jst|198855=judaic|198856=judaic studies|198857=judaism|198698=language|199110=languages|198908=latino|198705=law|198843=lib|198718=lifestyles|199087=ling 153|198835=ling 232|198811=ling 390|199029=ling 399|198812=ling 407|198813=ling 409|198814=ling 410|198815=ling 411|198816=ling 420|198817=ling 433|198818=ling 435|198819=ling 438|198820=ling 439|198821=ling 475|198822=ling 476|198823=ling 490|198824=ling 507|198825=ling 510|198826=ling 511|198827=ling 520|198828=ling 533|198829=ling 535|198830=ling 538|198831=ling 571|198832=ling 575|198833=ling 576|198834=ling 590|198972=ling559|198973=linguistics|199111=literature|198926=management|198714=marketing|198745=materials engineering|198741=materials science|198751=math|198746=mathematics|198747=mathematics &amp; statistics|198742=me|198743=mechanical &amp; materials engineering|198744=mechanical engineering|198638=media|198873=medieval|198874=medieval history|198909=mexican|198910=mexican american|198710=mgmt|199008=mgmt 428-001|198927=mgmt 446|198928=mgmt 481|198844=mim|198715=mktg|198847=mktg 338|198848=mktg 464-002|198849=mktg 467|198881=mktg 511|198738=mse|198748=mth|198809=mued|198913=multnomah|198808=mus|198838=non profit|198837=non-profit|198683=nonprofit|198793=nutrition|198956=occupational health|199117=oer|199114=oers|198957=omph|198739=omse|199115=open access|199116=open educational resources|198701=oregon|199009=organizational behavior|198684=pa|198682=pa 314u|198656=pa552|198914=pacific northwest|198685=pah|198659=pah 588|198958=pah574|198686=pap|198723=ph|198794=phe|199030=phe 250|198667=phe 327u|198639=phe 541|199003=phe443u|198959=phe512|198960=phe535|198961=phe580|198773=philosophy|199059=phonetics|198795=physical activity|198788=planning|198915=pnw|198774=policy|198642=political science|198775=political theory|198643=politics|198998=portland|198647=poverty|199098=prehistory|198877=primary sources|198652=program evaluation|198648=protest|198776=ps|198644=ps 410|199032=ps204|198645=ps410|199040=ps449|199041=ps549|198697=psy|199018=psy 317|199082=psy 321-001|199074=psy 321-002|198672=psy 321-003|199083=psy 321-004|198912=psy 471|199089=psy 497|199088=psy 597|198653=public administration|198962=public health|198687=public policy|199078=race|198711=re|198841=read|198783=real estate development|199053=religion|199052=religious studies|198654=research methods|199063=sager|199057=sci 201|198725=sci 338u-002|198702=science|198924=small business|198689=soc|198922=soc 397|199011=soc 420|199017=soc 594|199071=social movement|198649=social movements|198868=spain|199044=span 303|199060=span 325|199061=spanish|199043=spanish span 303h|198799=sped|198699=speech and hearing|198673=spirituality|198796=sports science|198749=stat|198750=statistics|198681=student leadership|198727=sustainability|198688=sw|199076=sw 340|198666=sw 450|199012=sw 510-003|198836=sw 520|198806=ta|199010=team processes|198879=technology|199004=toxicology|198784=transportation|198869=united kingdom|198703=united states|199055=unst|199077=unst 103a-001|199079=unst 103e-001|198976=unst 107|198977=unst 107a|198978=unst 107b|198979=unst 107c|198980=unst 107d|198981=unst 107e|198982=unst 107f|198983=unst 107g|198984=unst 107h|198985=unst 108|198986=unst 108a|198987=unst 108b|198988=unst 108c|199105=unst 108g|198989=unst 109|198990=unst 109a|198991=unst 109b|198992=unst 109c|198993=unst 109d|198994=unst 109e|198995=unst 109f|198996=unst 109g|198997=unst 109h|199036=unst 116e-001|199084=unst 119y|199068=unst 126e-001|199080=unst 133a-001|199001=unst 133e-001|199067=unst 139c|199064=unst 139e|198970=unst 212a-001|198671=unst 220e|198670=unst 220e-001|199108=unst 224a|199107=unst 224a-002|198895=unst 233c|199092=unst 233e|198797=unst 234|198678=unst 236c|199054=unst 236g-002 sinq|199069=unst 239g-001 sinq|199070=unst 242a|198999=unst 242g|199075=unst 254a-001 sinq|199081=unst 254e-002|199056=unst 254k-001|199058=unst 286|199050=unst 399u-001|199028=unst 421-517|199022=unst 421-522|199023=unst 421-524|199024=unst 421-530|220257=unst 421-538|199025=unst 421-539|199026=unst 421-553|199027=unst 421-591|199106=unst108c unst108g|199065=unst139e|199033=urban planning|198785=urban studies|198650=urban studies &amp; planning|198786=urban studies and planning|198770=us|198777=us politics|198771=usa|198787=usp|199072=usp 316|198651=usp 528|198916=washington|199035=ways|198674=women|198675=womens|199000=work|199112=world|199038=wr 115|199037=wr 121|199020=wrds|198853=ws|199048=ws 377u|198669=ws 377u-001|198676=ws 377u-002";
	$tags_parts = explode("|",$tags);
	foreach($tags_parts as $tag)
	{
		$tag_parts = explode("=",$tag);
		$tag_options[$tag_parts[1]] = $tag_parts[0];
	}
	// print("query: $query_string<br>\n");
	// print_r($tag_options);
	
	if(isset($tag_options[strtolower($query_string)]))
	{
		// tag exists for search
		// print("found matching tag... <br>\n");
		$tag_id = $tag_options[strtolower($query_string)];
		$result = utf8_encode(file_get_contents("http://lgapi.libapps.com/widgets.php?site_id=752&widget_type=1&search_terms=&search_match=2&sort_by=name&list_format=1&drop_text=Select+a+Guide...&output_format=1&load_type=2&enable_description=0&enable_group_search_limit=0&enable_subject_search_limit=0&tag_ids%5B0%5D=".$tag_id."&widget_embed_type=2&num_results=0&enable_more_results=0&window_target=2&config_id=1434150677187"));
	}
	else
		$result = "";
	
	if(USE_CACHE)
	{
		if(!strcmp(CACHE_TYPE,"database"))
		{
			// add to cache
			$fields = array("query_string","result","date_added");
			$values = array($query_string,$result,date('Y-m-d H:i:s',strtotime('now')));
			@insert('cache',$fields,$values);
		}
		else if(!strcmp(CACHE_TYPE,"memcache"))
		{
			if($memcache)
			{
				// print("<!-- adding $query_string to cache -->\n");
				@$memcache->set($query_string,$result,0,60*60*24);
			}
		}
	}
	
	return($result);
}



?>