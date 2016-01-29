<?php


return function ($ms) {
    return function ($ctx, $json) use ($ms) {
        switch ($json->block ? : __undefined) {
            case "content005":
                switch ($json->elem ? : __undefined) {
                    case "title-nested":
                        if (!isset($json->_m[4])) {
                            $json->_m[4] = true;
                            $subRes = $ms[4]["fn"]($ctx, $json);
                            if ($subRes !== null) {
                                return ($subRes ? : "");
                            }
                            if ($json->_stop) {
                                return;
                            }
                        }
                        break;
                    case "title":
                        if (!isset($json->_m[3])) {
                            $json->_m[3] = true;
                            $subRes = $ms[3]["fn"]($ctx, $json);
                            if ($subRes !== null) {
                                return ($subRes ? : "");
                            }
                            if ($json->_stop) {
                                return;
                            }
                        }
                        break;
                    case "text":
                        if (!isset($json->_m[2])) {
                            $json->_m[2] = true;
                            $subRes = $ms[2]["fn"]($ctx, $json);
                            if ($subRes !== null) {
                                return ($subRes ? : "");
                            }
                            if ($json->_stop) {
                                return;
                            }
                        }
                        break;
                }
                break;
            case "button":
                switch ($json->elem ? : __undefined) {
                    case __undefined:
                        if (!isset($json->_m[1])) {
                            $json->_m[1] = true;
                            $subRes = $ms[1]["fn"]($ctx, $json);
                            if ($subRes !== null) {
                                return ($subRes ? : "");
                            }
                            if ($json->_stop) {
                                return;
                            }
                        }
                        break;
                }
                break;
        }
        $json->_m[0] = true;
        $subRes = $ms[0]["fn"]($ctx, $json);
        if ($subRes !== null) {
            return ($subRes ? : "");
        }
        if ($json->_stop) {
            return;
        }
    };
};