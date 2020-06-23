<?php
include('simple_html_dom.php');

$hahu = "https://www.hasznaltauto.hu/talalatilista/";
$talalati = "PDNG2VHNN3RDAED4C47UARNACRVH4XTVXJFBLKTUB4IC2ZAJYYPYW3BHFJKLZ65NSOKIXAP4RE2LXGI5Z6HAG4RWS7PUCFSTFE2EJLGJFNMGGK2WRQKVFBBTLI2CO2BCOXILGFDA6LDPLAHPSWXTAYTIUGBHAFVLRWOAYJBNYMDHY2MVJMSC6UV4JTJCG3XL6CK2BBIUYVWH43MYJOAY2LZTSJFBNC7H4JU75KE6JAVDS6ZNSZH3HZPE7IKD6MSZTQBRHSYDPDNXIE3YL336NQJVPBYFWBKGQUDQ3U3EBAMHED3KFRRYGHWNDYRT2KC7BWRN64EIOCAMDOEJCQ55NTMWXVLTIYGFCXVU66YHUYR2465HHSDMNREQM3GHRVXA3HZHMHN7QLPQ2RHTZ2BT6ZHRF75FM3NR7OMHLJGXSTDWZGYQZF7KQEB7HVMYVCW4PM26UYLSBNPEHKOG5AV2GVFBGEO3Z3X3UI5DNYMAM3KJODUCFUNQJ4JHCCHSU7IUQYFJ6U5LK3CZZCFXWHRVZRVI5UWVGVXKVE4HLU3LVBMGZQ6JAZ3YEWVMQDL7JLP2XBZJOWC5XKIWADA4FGHHTWPCHW5BU7PD57KOPNKMP45BS345OTE7DMLQUO2DCGHQX3CBVWJZQP3EZOWTHBGRPFKNJWL5CQUEOG7LRGKCHBVU5IA66DEXA2QVNCT35RTAYEUBVVBRVU3ZJMBRSB6ZIZUYQ3J6NVAY43QGRI3MGY362GHNGHU4SJTUG4S4L25MZGO5U4MNPXBHAHBDFS7CKR336JKGOLF4ATTEA56CKDXMRV3ANSTGRUP7HP4MV7SHF6652HHRG7NDMFW5JDMOKH7W6GCZM";
$link = $hahu . "" . $talalati;

$base = file_get_html($link);
$lastPage = $base->find('li.last')[0]->plaintext; 
$data = array();

for($i = 1; $i <= $lastPage; $i++){
    $newURL = $link.'/page'.$i;
    $html = file_get_html($newURL);
    foreach($html->find('span[class*=friss]') as $friss) {
        $data[] = [
            "name"  => $friss->next_sibling()->children(0)->innertext,
            "url"   => $friss->next_sibling()->children(0)->href,
            "image" => $friss->parent()->parent()->parent()->parent()->find('img')[0]->getAttribute('data-lazyurl')
        ];
    }
}

require_once "con.php";

foreach ($data as $key => $value) {
    $result = $mysqli->query("SELECT url FROM data WHERE url = '".$value['url']."'");
    $count = $result->num_rows;
    if($count === 0){
        $mysqli->query("INSERT INTO data (name, url, image) VALUES ('".$value['name']."', '".$value['url']."', '".$value['image']."')");
    }
}
