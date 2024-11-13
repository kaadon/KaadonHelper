<?php
/**
 *   +----------------------------------------------------------------------
 *   | PROJECT:   [ KaadonHelper ]
 *   +----------------------------------------------------------------------
 *   | 官方网站:   [ https://developer.kaadon.com ]
 *   +----------------------------------------------------------------------
 *   | Author:    [ kaadon.com <kaadon.com@gmail.com>]
 *   +----------------------------------------------------------------------
 *   | Tool:      [ PhpStorm ]
 *   +----------------------------------------------------------------------
 *   | Date:      [ 2024/7/31 ]
 *   +----------------------------------------------------------------------
 *   | 版权所有    [ 2020~2024 kaadon.com ]
 *   +----------------------------------------------------------------------
 **/

namespace Kaadon\Helper;

/**
 * 常用测试助手
 */
class TestHelper
{
    /**
     * 生成随机的中国居民身份证号码
     * @return string
     */
    public static function generateChineseID(): string
    {
        $year = rand(1950, 2000);
        $month = str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT);
        $day = str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT); // Simplified to 28 days for all months

        // Generate random administrative division code
        $divisionCode = str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT);

        // Generate random sequence code
        $sequenceCode = str_pad(rand(100, 999), 3, '0', STR_PAD_LEFT);

        // Concatenate parts
        $partialID = $divisionCode . $year . $month . $day . $sequenceCode;

        // Calculate checksum
        $weights = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];
        $checksumChars = ['1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2'];
        $sum = 0;
        for ($i = 0; $i < 17; $i++) {
            $sum += intval($partialID[$i]) * $weights[$i];
        }
        $checksum = $checksumChars[$sum % 11];

        // Return full ID
        return $partialID . $checksum;
    }

    /**
     * 生成随机的手机号码
     * @return string
     */
    public static function generateMobile(): string
    {
        $prefix = ['130', '131', '132', '133', '134', '135', '136', '137', '138', '139', '150', '151', '152', '153', '155', '156', '157', '158', '159', '170', '171', '172', '173', '175', '176', '177', '178', '180', '181', '182', '183', '184', '185', '186', '187', '188', '189'];
        return $prefix[array_rand($prefix)] . mt_rand(1000, 9999) . mt_rand(1000, 9999);
    }

    /**
     * 生成随机的邮箱地址
     * @return string
     */
    public static function generateEmail(): string
    {
        $prefix = ['admin', 'service', 'info', 'contact', 'support', 'webmaster', 'sales', 'marketing', 'hr', 'finance', 'it', 'tech', 'help', 'media', 'press', 'jobs', 'career', 'feedback', 'enquiry', 'query', 'legal', 'complaint', 'abuse', 'postmaster', 'hostmaster', 'usenet', 'news', 'web', 'ftp', 'admin', 'noc', 'security', 'root', 'noreply', 'donotreply', 'marketing', 'sales', 'support', 'contact', 'enquiry', 'info', 'mail', 'hello', 'hi', 'service', 'contact', 'feedback', 'webmaster', 'admin', 'it', 'tech', 'hr', 'jobs', 'career', 'media', 'press', 'marketing', 'sales', 'support', 'contact', 'enquiry', 'info', 'mail', 'hello', 'hi', 'service', 'contact', 'feedback', 'webmaster', 'admin', 'it', 'tech', 'hr', 'jobs', 'career', 'media', 'press', 'marketing', 'sales', 'support', 'contact', 'enquiry', 'info', 'mail', 'hello', 'hi', 'service', 'contact', 'feedback', 'webmaster', 'admin', 'it', 'tech', 'hr', 'jobs', 'career', 'media', 'press', 'marketing', 'sales', 'support', 'contact', 'enquiry', 'info', 'mail', 'hello', 'hi', 'service', 'contact', 'feedback', 'webmaster', 'admin', 'it', 'tech', 'hr', 'jobs', 'career', 'media', 'press', 'marketing', 'sales', 'support', 'contact', 'enquiry', 'info', 'mail', 'hello', 'hi', 'service', 'contact', 'feedback', 'webmaster', 'admin', 'it', 'tech', 'hr', 'jobs', 'career', 'media', 'press', 'marketing', 'sales', 'support', 'contact', 'enquiry', 'info', 'mail', 'hello', 'hi', 'service', 'contact', 'feedback', 'webmaster', 'admin', 'it'];
        $suffix = ['@gmail.com', '@yahoo.com', '@hotmail.com', '@outlook.com', '@qq.com', '@163.com', '@126.com', '@sina.com', '@sohu.com', '@139.com', '@yeah.net', '@aliyun.com', '@foxmail.com', '@icloud.com', '@live.com', '@msn.com', '@aol.com', '@mail.com', '@inbox.com'];
        return $prefix[array_rand($prefix)] . mt_rand(100, 999) . $suffix[array_rand($suffix)];
    }

    /**
     * 生成随机的中国姓名
     * @return string
     */
    public static function generateChineseName(): string
    {
        $surname = ['赵', '钱', '孙', '李', '周', '吴', '郑', '王', '冯', '陈', '褚', '卫', '蒋', '沈', '韩', '杨', '朱', '秦', '尤', '许', '何', '吕', '施', '张', '孔', '曹', '严', '华', '金', '魏', '陶', '姜', '戚', '谢', '邹', '喻', '柏', '水', '窦', '章', '云', '苏', '潘', '葛', '奚', '范', '彭', '郎', '鲁', '韦', '昌', '马', '苗', '凤', '花', '方', '俞', '任', '袁', '柳', '酆', '鲍', '史', '唐', '费', '廉', '岑', '薛', '雷', '贺', '倪', '汤', '滕', '殷', '罗', '毕', '郝', '邬', '安', '常', '乐', '于', '时', '傅', '皮', '卞', '齐', '康', '伍', '余', '元', '卜', '顾', '孟', '平', '黄', '和', '穆', '萧', '尹', '姚', '邵', '湛', '汪', '祁', '毛', '禹', '狄', '米', '贝', '明', '臧', '计', '伏', '成', '戴', '谈', '宋', '茅', '庞', '熊', '纪', '舒', '屈', '项', '祝'];
        $givenName = ['子璇', '淼', '国栋', '夫子', '瑞', '欣欣', '涵', '予', '佳琪', '宸', '志强', '雪', '萌', '念', '思', '丹', '冰', '海', '欢', '悦', '静', '立', '夏', '嘉', '欣', '宜', '影', '翔', '梦', '涛', '明', '思', '杰', '婷', '立', '洁', '雪', '萍', '亮', '欣', '佳', '建', '晨', '翔', '云', '飞', '洋', '萍', '亮', '欢', '欢', '燕', '宇', '佳', '凌', '子', '博', '文', '霖', '云', '琦', '菲', '帆', '婷', '楠', '梦', '洁', '敏', '婷', '博', '超', '霖', '可', '昊', '伟', '洋', '甜', '甜', '静', '欣', '宇', '欣', '霖', '佳', '莹', '佳', '琪', '佳', '琦', '欣', '欣', '宇', '涵', '涵', '涵', '宇', '宇', '欣', '宇', '涵', '佳', '欣'];
        return $surname[array_rand($surname)] . $givenName[array_rand($givenName)];
    }

    /**
     * 生成随机的英文姓名
     * @return string
     */
    public static function generateEnglishName(): string
    {
        $firstName = ['James', 'John', 'Robert', 'Michael', 'William', 'David', 'Richard', 'Joseph', 'Thomas', 'Charles', 'Christopher', 'Daniel', 'Matthew', 'Anthony', 'Donald', 'Mark', 'Paul', 'Steven', 'Andrew', 'Kenneth', 'Joshua', 'George', 'Kevin', 'Brian', 'Edward', 'Ronald', 'Timothy', 'Jason', 'Jeffrey', 'Ryan', 'Jacob', 'Gary', 'Nicholas', 'Eric', 'Stephen', 'Jonathan', 'Larry', 'Justin', 'Scott', 'Brandon', 'Frank', 'Benjamin', 'Gregory', 'Samuel', 'Raymond', 'Patrick', 'Alexander', 'Jack', 'Dennis', 'Jerry', 'Tyler', 'Aaron', 'Jose', 'Henry', 'Adam', 'Douglas', 'Nathan', 'Peter', 'Zachary', 'Kyle', 'Walter', 'Harold', 'Jeremy', 'Ethan', 'Carl', 'Keith', 'Roger', 'Gerald', 'Christian', 'Terry', 'Sean', 'Arthur', 'Austin', 'Noah', 'Lawrence', 'Jesse', 'Joe', 'Bryan', 'Billy', 'Jordan', 'Albert', 'Dylan', 'Bruce', 'Willie', 'Gabriel', 'Alan', 'Juan', 'Louis', 'Jonathan', 'Wayne', 'Roy', 'Ralph', 'Randy', 'Eugene', 'Vincent', 'Russell', 'Elijah', 'Bobby', 'Philip', 'Harry', 'Johnny', 'Logan', 'Earl', 'Johnny', 'Jimmy', 'Clarence', 'Sean', 'Jesse', 'Antonio', 'Matthew', 'Fred', 'Isaac', 'Alex', 'Theodore', 'Leonard', 'Gavin', 'Evan', 'Herbert', 'Cody', 'Wesley', 'Derrick', 'Corey', 'Dylan'];
        $lastName = ['Smith', 'Johnson', 'Williams', 'Jones', 'Brown', 'Davis', 'Miller', 'Wilson', 'Moore', 'Taylor', 'Anderson', 'Thomas', 'Jackson', 'White', 'Harris', 'Martin', 'Thompson', 'Garcia', 'Martinez', 'Robinson', 'Clark', 'Rodriguez', 'Lewis', 'Lee', 'Walker', 'Hall', 'Allen', 'Young', 'Hernandez', 'King', 'Wright', 'Lopez', 'Hill', 'Scott', 'Green', 'Adams', 'Baker', 'Gonzalez', 'Nelson', 'Carter', 'Mitchell', 'Perez', 'Roberts', 'Turner', 'Phillips', 'Campbell', 'Parker', 'Evans', 'Edwards', 'Collins', 'Stewart', 'Sanchez', 'Morris', 'Rogers', 'Reed', 'Cook', 'Morgan', 'Bell', 'Murphy', 'Bailey', 'Rivera', 'Cooper', 'Richardson', 'Cox', 'Howard', 'Ward', 'Torres', 'Peterson', 'Gray', 'Ramirez', 'James', 'Watson', 'Brooks', 'Kelly', 'Sanders', 'Price', 'Bennett', 'Wood', 'Barnes', 'Ross', 'Henderson', 'Coleman', 'Jenkins', 'Perry', 'Powell', 'Long', 'Patterson', 'Hughes', 'Flores', 'Washington', 'Butler', 'Simmons', 'Foster', 'Gonzales', 'Bryant', 'Alexander', 'Russell', 'Griffin', 'Diaz', 'Hayes'];
        return $firstName[array_rand($firstName)] . ' ' . $lastName[array_rand($lastName)];

    }

    /**
     * 生成随机的地址
     * @return string
     */
    public static function generateAddress(): string{
        $province = ['北京市', '天津市', '河北省', '山西省', '内蒙古自治区', '辽宁省', '吉林省', '黑龙江省', '上海市', '江苏省', '浙江省', '安徽省', '福建省', '江西省', '山东省', '河南省', '湖北省', '湖南省', '广东省', '广西壮族自治区', '海南省', '重庆市', '四川省', '贵州省', '云南省', '西藏自治区', '陕西省', '甘肃省', '青海省', '宁夏回族自治区', '新疆维吾尔自治区', '台湾省', '香港特别行政区', '澳门特别行政区'];
        $city = ['北京市', '天津市', '石家庄市', '唐山市', '秦皇岛市', '邯郸市', '邢台市', '保定市', '张家口市', '承德市', '沧州市', '廊坊市', '衡水市', '太原市', '大同市', '阳泉市', '长治市', '晋城市', '朔州市', '晋中市', '运城市', '忻州市', '临汾市', '吕梁市', '呼和浩特市', '包头市', '乌海市', '赤峰市', '通辽市', '鄂尔多斯市', '呼伦贝尔市', '巴彦淖尔市', '乌兰察布市', '兴安盟', '锡林郭勒盟', '阿拉善盟', '沈阳市', '大连市', ];
        $district = ['东城区', '西城区', '朝阳区', '丰台区', '石景山区', '海淀区', '门头沟区', '房山区', '通州区', '顺义区', '昌平区', '大兴区', '怀柔区', '平谷区', '密云区', '延庆区'];
        $street = ['中山路', '中山大道', '中山街', '中山巷', '中山弄', '中山胡同', '中山坊', '中山里', '中山庄', '中山村', '中山园', '中山苑', '中山庭', '中山居', '中山城', '中山楼', '中山府', '中山宅', '中山庙', '中山寺'];
        return $province[array_rand($province)] . $city[array_rand($city)] . $district[array_rand($district)] . $street[array_rand($street)];
    }

    /**
     * 生成随机的IP地址
     * @return string
     */
    public static function generateIP(): string{
        return mt_rand(1, 255) . '.' . mt_rand(1, 255) . '.' . mt_rand(1, 255) . '.' . mt_rand(1, 255);
    }


}