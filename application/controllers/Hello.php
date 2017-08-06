<?php
/**
 * Created by PhpStorm.
 * User: fff
 * Date: 2017/8/6
 * Time: 22:49
 */

class Hello extends CI_Controller
{
    public function index()
    {
        function hello()
        {
            $hellolyrics = "看似美好的东西，往往藏着陷阱。
我是要成为程序猿的海贼王！
智商是硬伤。
年轻是我们唯一拥有权利去编织梦想的时光。
不相信自己的人，连努力的价值都没有。
没有梦想，那你认为自己的活着的意义是什么？
就是因为抱有不现实的梦想，所以才总是做出如此极端的事情！
我的腿让我停下，可是心却不允许我那么做。
年华无多时，恋爱吧男子！
每当对这个世界感到绝望的时候，买一包泡面，然后告诉自己：我们的泡面是有酱包的。
要改变别人的心真是件很难办的事，不过改变自己要容易一点。
胸不平何以平天下，乳不巨何以聚人心。
（根据相关法律法规，相关内容已被屏蔽。）
找不到路？那就自己走一条出来。
所谓的言语，只有当对方听进去了才开始有意义啊。
梦想，是人类进步的原因。";

            $hellolyrics = explode("\n", $hellolyrics);
            $hellochosen = $hellolyrics[mt_rand(0, ( count($hellolyrics) - 1 ))];

            $result = array(
                "content" => $hellochosen,
                "origin" => get_client_ip()
            );
            return $result;
        }

        $hello = hello();
        echo json_encode($hello, JSON_UNESCAPED_UNICODE);
    }
}