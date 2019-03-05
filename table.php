<?php


public function subscribeAction(){

        $get  =   $this->getRequest()->getQuery();
        $wid  =   $get['wid'];
        $uid  =   $get['uid'];
        if(!$wid){
            return false;
        }

        $obj    =   new   UserWeixinModel();
        $result =   $obj->find("uid='{$uid}'",['appId','openId','mac']);
        $extend = [];
        if($result){
            $extend  = [
                'appid'=>$result['appId'],
                'wxopenid'=>$result['openId']
            ];
        }
        LogApi::newLogCount($wid,$uid,11,9,$extend);

        $userInfo = new PortalUserInfoModel(null, $wid, $uid);
        $userInfo->initClientInfo();

        $portalInfo = new PortalInfoModel(null,$wid);
        $portalInfo->initWifiInfo();

        $wxConfig = WxConfigModel::getOtherWxConfigDataByAppidAndShopId(null, $portalInfo, $userInfo);

        $wxLogin = new WxLogin();
        $extend = $wxLogin->setWxExtend($userInfo->getUid(), $portalInfo->getWid(), $wxConfig['appid'], $wxConfig['oid']);

        $authUrl = $wxLogin->createWxUrl($portalInfo->getWid(), $userInfo->getUserMac(), $userInfo->getApSSID(), $userInfo->getApMac(), $extend, $wxConfig['appid'], $userInfo->getUid(), $wxConfig, false, '192.168.1.1','11');

        $timestamp = Tools::micTime();
        

        $sign = md5($wxConfig['appid'].$extend.$timestamp.$wxConfig['shopid'].$authUrl.$userInfo->getUserMac().$userInfo->getApSSID().$wxConfig['secretKey']);

        $data  = [
            'sign'=>$sign,
            'shopId'=>$wxConfig['shopid'],
            'authUrl'=>$authUrl,
            'mac'=>$userInfo->getUserMac(),
            'ssid'=>$userInfo->getApSSID(),
            'secretkey'=>$wxConfig['secretKey'],
            'timestamp'=>$timestamp,
            'extend'=>$extend,
            'appId'=>$wxConfig['appid'],
            'wid'=>$wid,
            'uid'=>$uid,
            'bssid'=>$userInfo->getApSSID()
        ];

        $this->out(['code'=>1,'data'=>$data]);

    }

t1.leyue100.com/normal/market/startWx?uid=m_414d7711d47d5ef7af6a23b172aefab6&wid=3bwsgfawzIZ&appid=wx8861daed37167b18&oid=78DfgFIn3TN&mtid=



  
 13) "APP::SHOP:23c9f1e1bdd0c943ccecc7ce738eddb9"
 14) "APP::SHOP:4c0d65c8aa3bc37d7e73e15d5ac24abe"
 15) "APP::SHOP:078914c32016de1f13b0cbc3e9fd4f12"
 16) "APP::SHOP:1f733ad8dd9a468f04bb61ba96c1f38b"
 17) "APP::SHOP:b22a53070e90522fd0bb73c5ff11e36f"
 18) "APP::SHOP:f3c77349feebe520366bdb9a4b5a7ac8"
 19) "APP::SHOP:30374b9237e9a0f761fc6eabe7321f30"
 20) "APP::SHOP:23fbdeeffe10da955654919af2f3b21b"
 21) "APP::SHOP:6b7c7453dbc0b5ff8484c75a394eb29a"
 22) "APP::SHOP:d2808d0014e1204dd821aa15769e51bf"
 23) "APP::SHOP:2f14f37504bd2916e6268287199ae3a9"
 24) "APP::SHOP:645f22fddf57ae45cdabd544b848671d"
 25) "APP::SHOP:262eb6a3df6e646617efe0e4471c5a2d"
 26) "APP::SHOP:fe8a5e8b1a1e023028121182813db5cb"
 27) "APP::SHOP:a47145e21d50d6643f7a54d6ea5b2916"
 28) "APP::SHOP:6eac994a09689da2935b15808842f553"
 29) "APP::SHOP:286149bdedbfba7bb73154f90f839bc4"
 30) "APP::SHOP:47a1d54578fc62e03b55dc120a1832fe"
 31) "APP::SHOP:148c9c524137b751ac193e334bc9e2d5"
 32) "APP::SHOP:1034ced84f457d55d9bc5e45913015fc"
 33) "APP::SHOP:681cacd0157ac59d4ab94278385ac828"
 34) "APP::SHOP:df5fd7254720aed0d8db641ea94b4165"
 35) "APP::SHOP:890172406c37d15546ac2d691a0ae5ad"
 36) "APP::SHOP:8a9aa15c17ee2e76022fbb0fe258c6c9"
 37) "APP::SHOP:ce411fb7997c89861983fbaca70f5ca2"
 38) "APP::SHOP:cb7a62484a74859ca16ba7b189866db2"
 39) "APP::SHOP:5498a13cbfe4fd0807538e7d0669da52"
 40) "APP::SHOP:9890788e0355cfb56a07d6293f16f728"
 41) "APP::SHOP:774a0ea3583dee1e3bb95bedd69020e1"
 42) "APP::SHOP:89991899b7ce92b29b4f193f3100f9ca"
 43) "APP::SHOP:6adffb8235f9f5cb91e033524eec9dc8"
 44) "APP::SHOP:4843e2705d99cb5102bd9eb9601c34b2"
 45) "APP::SHOP:fd45705ecf910aa6d7afe6d037a62c03"
 46) "APP::SHOP:b2f3e5320562d208b6956d8c3ac4bb36"
 47) "APP::SHOP:8b2a5f16b7ed79cac13e434be28123d7"
 48) "APP::SHOP:27c4c5515020b1ade6ee22865e16b8cd"
 49) "APP::SHOP:2ce3373221fb2606492c7cfd348c6240"
 50) "APP::SHOP:2c8faddfa47fca8db94dad6422a7b782"
 51) "APP::SHOP:7b161f6e0f90c3e64007664d7df78041"
 52) "APP::SHOP:36f9e31d1e876f21b532b9ad8a5a8394"
 53) "APP::SHOP:6678b978802a1e85795b53efcb15352e"
 54) "APP::SHOP:0da394f87d4013137465aeb922eaa847"
 55) "APP::SHOP:2af2b9aa41b35cf438d38d5d4441cfdb"
 56) "APP::SHOP:6f7915531e09ff011b8d6f98074894da"
 57) "APP::SHOP:e56398f74594235f12e77f6ec40868db"
 58) "APP::SHOP:7189cd21da23db7856406489418f3df9"
 59) "APP::SHOP:59aee18ed0b729078dcc21a5c55209e7"
 60) "APP::SHOP:16b7668fa2f490cf217cc5d3e5492088"
 61) "APP::SHOP:7180a10022bb24b8871907e8eaa00063"
 62) "APP::SHOP:ded2dd7aba5bfdb048b2b1a88f667317"
 63) "APP::SHOP:36d6ccf8298dbbeb6f3049a5ba842077"
 64) "APP::SHOP:60dbff1c99c6110d70301c17ead497c5"
 65) "APP::SHOP:0f417a30e8b656b9af38524daa427d8b"
 66) "APP::SHOP:8c27b4b75fc3c22279a63a913901e06d"
 67) "APP::SHOP:1ab14c6457f3bef6795188ab7021dd1f"
 68) "APP::SHOP:08aa89215f72c03bcb340596a675ef3f"
 69) "APP::SHOP:2adbe8b0beb78c6636e82b6462a7fc5c"
 70) "APP::SHOP:a7c1c2315661ad5794daaf177358ddd9"
 71) "APP::SHOP:c019642142e8746f7f31ad24acd44d0c"
 72) "APP::SHOP:f9d03c39e5993383a482c69fd5c3df36"
 73) "APP::SHOP:326dabe0441e5256af6dd43ba12f1015"
 74) "APP::SHOP:0d6143a4bd557c07f2e8c559f86412c4"
 75) "APP::SHOP:02b1c3140334d73c9e5960cced4a2a32"
 76) "APP::SHOP:90a27c22e49fb2bfd9f2a4b89583b3bd"
 77) "APP::SHOP:8e3ca46892d68b81e0bdd2ac2ff45931"
 78) "APP::SHOP:045165966d8f25afa08f34c7702d05c4"
 79) "APP::SHOP:9e8f9bef287ba5a84452efb1eddcd188"
 80) "APP::SHOP:5b73f36aa2d0513d67d2bda52d3c3659"
 81) "APP::SHOP:b512f01cd5b5d76dcbeeb5d83bfbc575"
 82) "APP::SHOP:15d411f1ff60e58d389e1011c7801ba6"
 83) "APP::SHOP:0b4bc44d5406c1f7c4747066a41cb40c"
 84) "APP::SHOP:5b36c365b901d73eb89160f0ea18b4b9"
 85) "APP::SHOP:29ed73de9b4931aa4543892b25b96534"
 86) "APP::SHOP:e202bac3dd3a7eb71f1bab96286fe54a"
 87) "APP::SHOP:89f2cb44a7061aeb18be19fc6d713648"
 88) "APP::SHOP:4fcc6efad2865af092eb8c62a633d894"
 89) "APP::SHOP:b2edf8ebb85ffec90746b39b55d3bf3a"
 90) "APP::SHOP:1464e8227a4f8bbbe1e3773a2edba5ba"
 91) "APP::SHOP:7cbb399cf3004ab7464ead6ba2a3be85"
 92) "APP::SHOP:97f523da3133a98100e7eb2d181b5739"
 93) "APP::SHOP:63bda97ee1ba1893544f2db5c5a4c399"
 94) "APP::SHOP:2e8dc9263ef86b2a595c2ad459049dd6"
 95) "APP::SHOP:17663f85b1ed2174edc384f368835166"
 96) "APP::SHOP:950f7f010a7f2d7a417796efe358f1c9"
 97) "APP::SHOP:e9fd21322f0ce2637328170579a22b5e"
 98) "APP::SHOP:5757b66dd8afc0ce4bdbbfb616edc4c7"
 99) "APP::SHOP:ab8b08b6bc9aeff8515968e801ce06c3"
100) "APP::SHOP:61f469513c1e74008bb139603ae21698"
101) "APP::SHOP:b185f973c241b3121b7bab13f81462f5"
102) "APP::SHOP:14897a11355ad77233767241969b2726"
103) "APP::SHOP:45c273fb852c0fc52635df4de59c994a"
104) "APP::SHOP:280343a60f7c942ea0ea769870bc7b6f"
105) "APP::SHOP:b3a8b538d8e09ead348a37bc4faf78cd"
106) "APP::SHOP:f5776ba156332abfee217ea1e7c4943c"
107) "APP::SHOP:18051fc2644990226cd7aa057b0560a2"
108) "APP::SHOP:54707de2911fbaf45f6506f56e76f5fc"
109) "APP::SHOP:296cdc756663090babca3e33e51629e3"
110) "APP::SHOP:308d4142ca64dfb6e407f22730fb7431"
111) "APP::SHOP:ba8755c8b550b03a8b3b5cf3c6fc56a2"
112) "APP::SHOP:71ebcebc418e148dff1b5a030a7a494d"
113) "APP::SHOP:65c0eeb7233e67a9a520dca7ef187e94"
114) "APP::SHOP:1fc524f2386c5dc75d21b4f9cab3c655"
115) "APP::SHOP:8617183e481c53157461aa6e15cfe7e1"
116) "APP::SHOP:c292e003f263ca065a9c8467b249702c"
117) "APP::SHOP:241533c76342d295bde9e137caa265f6"
118) "APP::SHOP:adbdd25ccdc7bb2d1a7db25012c5a427"
119) "APP::SHOP:84f6b43f30629caf65243a0c86cb42a1"
120) "APP::SHOP:6b619c6ad55d933567da838c82c5fa99"
121) "APP::SHOP:182f76e586e002237610b23de144a84e"
122) "APP::SHOP:2a0f3e1cb9ac39ba39f94c8da1d7fae0"
123) "APP::SHOP:3a8f5dd4c3fe1be5e8ee7061c0039c90"
124) "APP::SHOP:f26d851340dff23de5ce1a6cd269f264"
125) "APP::SHOP:cf049922e4e1b7f4d6fea185035bb810"
126) "APP::SHOP:64a9e237226a17e41c0100c11984e701"
127) "APP::SHOP:9946962895611d80d3f450193e370789"
128) "APP::SHOP:60050fd7797df1648235ab537c244f5a"
129) "APP::SHOP:0968762ebf07effb5043961d964738de"
130) "APP::SHOP:0874a6c64b9fb0ff4c1922267c358742"
131) "APP::SHOP:a540b6e3bb0b40362f5ec05c4f23bf77"
132) "APP::SHOP:fa595c0670daf9039e9ad27a9611b0f7"
133) "APP::SHOP:81ea331b7105f48cc370d7bd32c5a854"
134) "APP::SHOP:1da1f8c50067146d8c42873794e0e0e4"
135) "APP::SHOP:e2841b73001f60dcb18acfe50b051141"
136) "APP::SHOP:808075e5db249bc0c0b0ada11eebacf2"
137) "APP::SHOP:0fd33b8bc4ce4d8c755e2c965192e9a7"
138) "APP::SHOP:b00effe7cd13234f08a039967208d627"
139) "APP::SHOP:442825d4edad591fec754cedd3d1dd89"
140) "APP::SHOP:6014a44b53f2b8aea9bbf428454300e3"
141) "APP::SHOP:ddac332ca983e9948d9bfc38019cca72"
142) "APP::SHOP:cd96bcd4a5e00b1285e9d548bde729b1"
143) "APP::SHOP:2766f4feacec3b67892987770dae89fc"
144) "APP::SHOP:5304c9b426261bc0cae67697d638096f"
145) "APP::SHOP:10c574cf1283a4a98d96853922062477"
146) "APP::SHOP:decffa8fee7ab92243db98b1da169a62"
147) "APP::SHOP:194c82fc525812ea96bf8f1c10c6a51e"
148) "APP::SHOP:e8accccb330dc217646e1d095337bd51"
149) "APP::SHOP:8e883e1609eb499e92d666acfceb2aa8"
150) "APP::SHOP:dc735114f75f48d758d41fc891d1564e"
151) "APP::SHOP:27b5944b91c4808ee62902abe2a58c84"
152) "APP::SHOP:3c0c0cb85a8825a85d52a135cd868355"
153) "APP::SHOP:13a37564d3e4fdbd3d8d9c129f48d3d5"
154) "APP::SHOP:a0dae3df6949adba196a7f587fe06e16"
155) "APP::SHOP:a685144e2cb6b59ec634006ca8b0df4c"
156) "APP::SHOP:ceedcee283e17067a77f6a8fd3d607f6"
157) "APP::SHOP:df0b1f42fee6439de128c696784144e1"
158) "APP::SHOP:7fa71c25d3c2e31b687db926a094326c"
159) "APP::SHOP:90ff6e06e6b60922eeaf1db19120d71d"
160) "APP::SHOP:bee3b0dcc19422e23031ab825124e355"
161) "APP::SHOP:bcdf59405044c94b03092eb9d067f5b8"
162) "APP::SHOP:611009dacfc9c7dd5d22aa52661cfeaa"
163) "APP::SHOP:f6ba632f530c9dd2bfd3ae129d864b87"
164) "APP::SHOP:e4ebd863bcc961742d88629eb63ce08e"
165) "APP::SHOP:a034b64e2640df297ebbac7f24c67230"
166) "APP::SHOP:64f6d4e75398d4fcbbc2f8ac379298de"
167) "APP::SHOP:9ee8968160f95570529cf582d27b1c86"
168) "APP::SHOP:fd2894653bb27d0360c0ebb59d233f38"
169) "APP::SHOP:a2a0f08566d738cc68d9f7fd5b4a229a"
170) "APP::SHOP:4366ad8468f9bcad155c0033b8e5b158"
171) "APP::SHOP:de9cb12af8aa7c7b7c005a031ca30a25"
172) "APP::SHOP:8a6fabb7fc44e7885f8e8e8c5d48a494"
173) "APP::SHOP:c440f95c4ca34f6832ae141efdcf7ff5"
174) "APP::SHOP:9aa0699039bd404a966de176134106cc"
175) "APP::SHOP:4cf289108725bd0544ff24a2c1c68215"
176) "APP::SHOP:bb325da8d2f1b1654b0ec81fcf5aadb1 



    2017-03-28 15:24:24] [I] [211.167.232.2] MSG:[(2){"$posts":{"from":"register","orderNo":"leyi-2017032897505499","body":"2017-03-30 \u5e7f\u5dde\u534e\u4fa8\u533b\u9662 \u9aa8\u79d1\u95e8\u8bca \u9648\u65b0\u533b\u751f - \u6302\u53f7\u8d39\u7528","type":"1","upid":"hs1JPiS2CRU","id":"iOzkGkZEAly","payType":"1","return_url":"http:\/\/v2017.leyue100.com\/aw\/pay\/check?hid=j3TTzstpa3y&id=iOzkGkZEAly&upid=hs1JPiS2CRU&type=1&orderNo=leyi-2017032897505499"},"$data":{"code":1,"message":"","data":"_input_charset=utf-8&body=2017-03-30+%E5%B9%BF%E5%B7%9E%E5%8D%8E%E4%BE%A8%E5%8C%BB%E9%99%A2+%E9%AA%A8%E7%A7%91%E9%97%A8%E8%AF%8A+%E9%99%88%E6%96%B0%E5%8C%BB%E7%94%9F+-+%E6%8C%82%E5%8F%B7%E8%B4%B9%E7%94%A8&it_b_pay=5m&notify_url=http%3A%2F%2Fapi2015.leyue100.com%2Fpay%2FalipayNotify&out_trade_no=leyi-2017032897505499&partner=2088511060199864&payment_type=1&return_url=http%3A%2F%2Fv2017.leyue100.com%2Faw%2Fpay%2Fcheck%3Fhid%3Dj3TTzstpa3y%26id%3DiOzkGkZEAly%26upid%3Dhs1JPiS2CRU%26type%3D1%26orderNo%3Dleyi-2017032897505499&seller_id=hqyy_jnuh%40163.com&service=alipay.wap.create.direct.pay.by.user&subject=2017-03-30+%E5%B9%BF%E5%B7%9E%E5%8D%8E%E4%BE%A8%E5%8C%BB%E9%99%A2+%E9%AA%A8%E7%A7%91%E9%97%A8%E8%AF%8A+%E9%99%88%E6%96%B0%E5%8C%BB%E7%94%9F+-+%E6%8C%82%E5%8F%B7%E8%B4%B9%E7%94%A8&total_fee=7.00&sign=cu29q6hoRN%2F90KvTvC6%2BwzGcdITPFIFhx5YX5gIkAN6%2BkpHkT89fLBm%2FfE5oDbmucXA1fxaObvwZnsHyufQtzUEAOeOvVYYeI42lv9xEONEJseo%2FCkHagmX5GScsezMqnqXbuGcI0Z7JTx8QNN6UeYPzhXG8S6NVY%2FSOytVlINQ%3D&sign_type=RSA"}}] Location:/data2/www/deploy/WIFI_Re_TEST/lywifiauth/www/index.php QUERY_STRING:aw/pay/waiting&hid=j3TTzstpa3y&rid=iOzkGkZEAly HTTP_REFERER:http://v2017test.leyue100.com/aw/registered/order?hid=j3TTzstpa3y&browser_act=%2Faw%2Fregistered%2Fdetail%3Ftpid%3DiOzkGkZEAly%26did%3DeVqKsuWGA8T%26dmid%3DaHuu0b82kfX%26hid%3Dj3TTzstpa3y%26upid%3Dhs1JPiS2CRU%26payType%3D1&upid=hs1JPiS2CRU User-Agent:Mozilla/5.0 (iPhone; CPU iPhone OS 10_1_1 like Mac OS X) AppleWebKit/602.2.14 (KHTML, like Gecko) Version/10.0 Mobile/14B100 Safari/602.1







http://portal.leyue100.com/wifi/home/index?wid=lUNcNWMsDQC&uid=m_4f41f0a4609fdda979d1026f198d38f2&hid=cqbN7K9XFqR&pid=&style=wifi_home

t1.leyue100.com/portal/home/startwx/uid/m_414d7711d47d5ef7af6a23b172aefab6/wid/1QBh58wQtLW




wxec941f8da020fe9e


wx65ef90cad2d3e83f 爱国 1
wxb81b9f2b137d45f7 广东 1
wxa5b996a40a0ecf86 上海 1
wx8861daed37167b18
wxafc44a2389d56e7f 四川 1
wx47a9c8a67db87263 湖北 1 
wx93ab1f4e5317df21 乐约 1
wxa5b996a40a0ecf86 上海 1
wxb81b9f2b137d45f7 广东
wx859240f6c60a2fa6


http://t1.leyue100.com/advertisement/newcount/delWxListRedis?wid=lUNcNWMsDQC&uid=m_414d7711d47d5ef7af6a23b172aefab6&appid=wx8861daed37167b18|wxa5b996a40a0ecf86|wxb81b9f2b137d45f7|wx65ef90cad2d3e83f



8j2C7f8C73c
dlVC6jAxeyZ
3fB69hXm0Y8
g3nAldrMmFW
3RVnJErVcmz
3hoH2YZBvf1
eIH9O3T6oG5

db.sales.aggregate(
   [
      {
        $group : {
           _id : { month: { $month: "$date" }, day: { $dayOfMonth: "$date" }, year: { $year: "$date" } },
           totalPrice: { $sum: { $multiply: [ "$price", "$quantity" ] } },
           averageQuantity: { $avg: "$quantity" },
           count: { $sum: 1 }
        }
      }
   ]
)


北京友谊医院	Aruba	aD9jsXXJWRY
江苏省中医院	湛艺	hwgoWo8GyAg
南京市妇幼保健院	湛艺	l1AVkOP9mKq
南京市中医院	湛艺	hTOjHkX2Xg8
南京医科大学第二附属医院	湛艺	f2G4J6PIYHK
解放军454医院	湛艺	3S6nnRHSBQt
江苏省机关医院	湛艺	jicikjoOxNX
广州医科大学附属第四医院	慷慨	95eJnx6KaIP
中山大学孙逸仙纪念医院（本院）	慷慨	8QspJcmvOyR
中山大学孙逸仙纪念医院南院	慷慨	1wMZ03ir7VV
广州市红十字会医院	慷慨	d9KqW8saoj7
中山大学附属口腔医院(本院)	慷慨	fk5lbuSh2xA


http://t1.leyue100.com/wifi/home/index?wid=1LbgBixCDeK&uid=m_414d7711d47d5ef7af6a23b172aefab6&hid=cqbN7K9XFqR
MSG:[::------::[{"role":"1","weights":"100","create":"2017-03-15 14:29:00","update":"0000-00-00 00:00:00","advType":"float_img","placeId":"p00007","status":"success","width":"640","height":"120","mtid":"8B8iTaJLvqX","partner":"\u6291\u90c1\u75c7","dep":"{\"aCbiiJPwxKm\":[\"1hUbu72ySG2\"]}","items":{"uri":"http:\/\/oss.portal.lywf.me\/misc\/images_lower\/lm\/m5\/lmfROvOe5m5.jpg","link":"http:\/\/www.bch-syfy.cn\/","text":"","partner":"\u6291\u90c1\u75c7","closeBtn":true,"linkType":"extra","click":"enabled","css":{"max-height":"120px","width":"100%","left":"0","bottom":"-11px"}}}]] Location:/data/web/lywifiauth_test/lywifiauth/www/index.php QUERY_STRING:api/adv/getMaterialByPlace/&pcid=p00007&wid=1LbgBixCDeK&pageId=wifi_home&uid=m_4f41f0a4609fdda979d1026f198d38f2 HTTP_REFERER: User-Agent:Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1

"dep":"{\"aCbiiJPwxKm\":[\"1hUbu72ySG2\"]}"
{"dParentId":"1GmQO2UHNBb,1GmQO2UHNBb,48rqR54Tea6,NhNX9BEIRb","apmac":"94:f6:65:3f:db:b0","did":"1HNloieVD8x,5nZFguoQfaM,3r6tGKiEco1,8BFXFrs0K3O"}


[2017-03-15 15:00:03] [I] [211.167.232.2] MSG:[[:AP_MAC:]{"dParentId":"1GmQO2UHNBb,1GmQO2UHNBb,48rqR54Tea6,NhNX9BEIRb","apmac":"94:f6:65:3f:db:b0","did":"1HNloieVD8x,5nZFguoQfaM,3r6tGKiEco1,8BFXFrs0K3O"}] Location:/data/web/lywifiauth_test/lywifiauth/www/index.php QUERY_STRING:api/adv/getMaterialByPlace/&pcid=p00007&wid=1LbgBixCDeK&pageId=wifi_home&uid=m_4f41f0a4609fdda979d1026f198d38f2 HTTP_REFERER: User-Agent:Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1
[2017-03-15 15:00:03] [I] [211.167.232.2] MSG:[::::[]] Location:/data/web/lywifiauth_test/lywifiauth/www/index.php QUERY_STRING:api/adv/getMaterialByPlace/&pcid=p00007&wid=1LbgBixCDeK&pageId=wifi_home&uid=m_4f41f0a4609fdda979d1026f198d38f2 HTTP_REFERER: User-Agent:Mozilla/5.0 (iPad; CPU OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1









http://t1.leyue100.com/advertisement/newcount/delWxListRedis?wid=lUNcNWMsDQC&uid=m_4f41f0a4609fdda979d1026f198d38f2&appid=wx8861daed37167b18|wxa5b996a40a0ecf86|wxb81b9f2b137d45f7|wx65ef90cad2d3e83f



http://t1.leyue100.com/advertisement/newcount/delWxListRedis?wid=lUNcNWMsDQC&uid=m_414d7711d47d5ef7af6a23b172aefab6&appid=wx8861daed37167b18|wxa5b996a40a0ecf86|wxb81b9f2b137d45f7|wx65ef90cad2d3e83f

http://t1.leyue100.com/advertisement/newcount/delWxListRedis?wid=lUNcNWMsDQC&uid=m_944a4054d82e803d153d1a3da03129fa&appid=wx8861daed37167b18|wxa5b996a40a0ecf86|wxb81b9f2b137d45f7|wx65ef90cad2d3e83f

http://portal.leyue100.com/wifi/home/index?wid=lUNcNWMsDQC&uid=m_4f41f0a4609fdda979d1026f198d38f2&hid=cqbN7K9XFqR&pid=&style=wifi_home

//echo in_array('p/byftfhdmzaq', ['p/byftfhdmzaq', 'p/byftfhdmza']) ? 'byftfhdmzaq' : 'p/byftfhdmzaq';

/*
{"dParentId":"48rqR54Tea6,NhNX9BEIRb,dVStXHFvpPz","did":"4X3QU2jyoS5,null,3zCnvCmagnq","apmac":"94:f6:65:3f:db:b0"}


INSERT INTO ads_compaigns_count_new (ccid,cid,today,viewNum,clickNum,personNum,visitorClickNum,visitorPersonNum,ccCreated) VALUES ('83GUigVVNJO','a5z5giyhvud','2016-08-02','800013','48266','0','0','0','2016-12-08 15:21:08'),
('jUxU55qP1VG','sys2','2016-08-02','125135','6','0','0','0','2016-12-08 15:21:08'),
('eMxKn5pByxI','sys3','2016-08-02','353626','99','0','0','0','2016-12-08 15:21:08'),
('yV1m5jUROT','2kweiijzlvn','2016-08-02','4257','51','0','0','0','2016-12-08 15:21:08'),
('1rZWXLPduGy','84wqjbtf5py','2016-08-02','427801','43','0','0','0','2016-12-08 15:21:08'),
('eqYIOFmCIHJ','2mprn1lffqc','2016-08-02','14601','82','0','0','0','2016-12-08 15:21:08'),
('kZR52Wh06LO','5xkstrcxmmm','2016-08-02','113102','490','0','0','0','2016-12-08 15:21:08'),
('7LpSMYLWfjT','sys1','2016-08-02','39110','193','0','0','0','2016-12-08 15:21:08'),
('bszYzrvYAJG','gvxacxqo3jc','2016-08-02','32173','379','0','0','0','2016-12-08 15:21:08'),
('2XkCPVBXZ1m','5tvnmhzcal9','2016-08-02','12945','276','0','0','0','2016-12-08 15:21:08'),
('fNC5HcgQAxo','ej7opi5s7ct','2016-08-02','6992','30','0','0','0','2016-12-08 15:21:08'),
('egoNeMOwsWs','','2016-08-02','20102','37','0','0','0','2016-12-08 15:21:08'),
('4WSD53YuRVT','eldrhigsdlu','2016-08-02','25','0','0','0','0','2016-12-08 15:21:08'),
('2tKQEnKQNf3','70hufylc5mz','2016-08-02','37','5','0','0','0','2016-12-08 15:21:08'),
('99Z7PQXYRHC','dbeewnpmwwd','2016-08-02','18','0','0','0','0','2016-12-08 15:21:08'),
('3T9lVNWYFS6','fun1ld2n1bk','2016-08-02','184','0','0','0','0','2016-12-08 15:21:08'),
('zxLVthtxej','lganm1yab7l','2016-08-02','8','0','0','0','0','2016-12-08 15:21:08'),
('gEkIS13EBbJ','9yxvqt8mrqr','2016-08-02','6','0','0','0','0','2016-12-08 15:21:08'),
('kLfRYnFrxcG','cdu67rasjad','2016-08-02','2','0','0','0','0','2016-12-08 15:21:08'),
('7pVlW3WqCoS','m320_120_2','2016-08-02','6','0','0','0','0','2016-12-08 15:21:08'),
('dT0TrT1t88f','m320_120_1','2016-08-02','1','0','5314','0','2016-12-08 15:21:08'),
('1Fq1LCge7Zy','{','2016-08-02','1','0','1','0','2016-12-08 15:21:08')

*/


/**
 * Created by macbookpro on 16/12/1.
 * 李红生 用于统计广告UV
 */

var temp_name = 'temp_collections_user_' + dateVal + '_' + category;
var drop = 'db.'+temp_name+'.drop()';
eval(drop);

db.runCommand({
    mapreduce : collection,
    map : function Map(){
        emit( {uid:this.uid,wid:this.extend.wid}, 1);
    },
    reduce : function Reduce(key, emits) {

    },
    finalize : function Finalize(key, value) {
        return key.wid;
    },
    query : objCond,
    out : temp_name
});

db.runCommand(
    {"group": {
        "ns": temp_name,
        "key": {'value':true},
        "initial": {"count": 0},
        "$reduce": function(doc, prev) {
            prev.count++;
        }
    }}
).retval.forEach(function(data){
        ret[n] = [];
        ret[n].push(data.value);
        ret[n].push(data.count);
        n++;

    });

eval(drop);

print(JSON.stringify(ret));

*/


















class Node {
	public $next; //指针域
	public $dateType;//数据域
	
}

class Nohead {
	public $head; //头结点
	
	public $size; //当前个数
	
	public function __construct() {
		$this->size = 0;
		$this->head = new Node;
		$this->head->next = $this->head;
		$this->head->dateType = null;
		
	}
	
	//获得节点数
	public function getNum() {
		$p = $this->head;
		$size = 0;
		while(!($p->next === $this->head)) {
			$p = $p->next;
			$size ++;
		}
		return $size;
	}
	
	//插入节点
	public function insert($i,$DateType) {
		
			$p = $this->head;
			$j = -1;
			/*
			判断当前节点存在并且i节点存在的情况下
			  $p->next != null 判断当前节点存在，且i节点存在
			  $j < $i-1判断循环到I-1节点
			循环到要插入元素的位置的前一个元素。*/
			
			while(!($p->next === $this->head) && $j < $i-1) { //循环到要插入元素的位置的前一个元素。
				$p = $p->next;
				$j++;
				
			}
			
			if(!($j === $i-1)) {//此条件判断$p为I-1节点，如果此时I-1为-1则$p 还是头结点
				
				echo "False";
				return false;
			}
			
			$q = new Node;              //新建一个结点
			$q->dateType = $DateType;
			
			$q->next = $p->next;  //把插入当前元素的前一个元素的指向域赋予新建结点
			$p->next = $q;  //把插入当前元素的前一个元素的指向域指向新建结点
			return 1;
			
		
		
	}
	
	
	//删除节点
	public function delete($i) {
		
			$p = $this->head;
			$j = -1;
			while($p->next != null && $j < $i-1) { //循环到要插入元素的位置的前一个元素。
				$p = $p->next;
				$j++;
				
			}
			
			if(!($j === ($i-1))) {
				
				echo "False";
				return false;
			}
			
			
			
			$p->next = $p->next->next;  
			return 1;
			
	}
	
}

echo "<br/><br/>:链式结构<br/>";
$table = new Nohead;
$table->insert(0,1);
//$table->delete(0);
$table->insert(1,2);
$table->insert(2,3);
echo $table->getNum()."<br/>";
 $p = $table->head;
while(!($p->next === $table->head)) {

	$p = $p->next;
	echo $p->dateType."<br/>";
	
}