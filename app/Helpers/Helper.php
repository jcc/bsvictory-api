<?php

if (!function_exists('make_request')) {
    /**
     * 发送HTTP请求
     */
    function make_request($url)
    {
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            CURLOPT_FOLLOWLOCATION => true,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($httpCode === 200) {
            return $response;
        }

        return false;
    }
}

if (!function_exists('parse_response')) {
    /**
     * 解析响应数据
     */
    function parse_response($response) {
        $lines = explode(';', $response);
        $result = [];

        foreach ($lines as $line) {
            if (!strpos($line, '=')) continue;

            $parsedData = parse_single_stock($line);

            $result[] = $parsedData;
        }

        return $result;
    }
}

if (!function_exists('parse_single_stock')) {
    /**
     * 解析单只股票数据
     */
    function parse_single_stock($line)
    {
        $stock = explode('~', explode('"', $line)[1]);

        return [
            // 'name' => iconv('GB2312', 'UTF-8', $stock[1]), // 名字
            'name' => $stock[1],
            'code' => $stock[2], // 代码
            'current_price' => $stock[3], // 当前价格
            'yesterday_close' => $stock[4], // 昨收
            'open_price' => $stock[5], // 今开
            'volume' => $stock[6],  // 成交量(手)
            'bid_volume' => $stock[7],  // 外盘(主动买入)
            'ask_volume' => $stock[8],  // 内盘(主动卖出)
            'buy1_price' => $stock[9], // 买一
            'buy1_volume' => $stock[10], // 买一量（手）
            'buy2_price' => $stock[11],
            'buy2_volume' => $stock[12],
            'buy3_price' => $stock[13],
            'buy3_volume' => $stock[14],
            'buy4_price' => $stock[15],
            'buy4_volume' => $stock[16],
            'buy5_price' => $stock[17],
            'buy5_volume' => $stock[18],
            'sell1_price' => $stock[19],
            'sell1_volume' => $stock[20],
            'sell2_price' => $stock[21],
            'sell2_volume' => $stock[22],
            'sell3_price' => $stock[23],
            'sell3_volume' => $stock[24],
            'sell4_price' => $stock[25],
            'sell4_volume' => $stock[26],
            'sell5_price' => $stock[27],
            'sell5_volume' => $stock[28],
            'trade_time' => $stock[29], // 最近逐笔成交
            'price_change' => $stock[31], // 涨跌
            'price_change_percent' => $stock[32] . '%', // 涨跌%
            'highest_price' => $stock[33], // 最高
            'lowest_price' => $stock[34], // 最低
            'turnover' => $stock[38] ? $stock[38] . '%' : 0,  // 换手率
            'pe_ratio' => $stock[39] ? $stock[39] : 0,  // 市盈率
            'amplitude' => $stock[43] ? $stock[43] : 0,  // 振幅
            'total_market_value' => $stock[44] ? $stock[44] : 0,  // 总市值
            'circulating_market_value' => $stock[45] ? $stock[45] : 0,  // 流通市值
        ];
    }
}
