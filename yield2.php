<?php 

$str = '      
{
    "requestId":"du34qrM2pON",
    "requestSubId":"4LI2WSduOxw",
    "taskName":"insPrefile",
    "apiName":"insPrefile",
    "hid":"hi862LMIcSO",
    "hpid":"j722vNpmW6C",
    "sync":false,
    "param":{
        "credentialType":"01",
        "timeLimit":1,
        "caseNum":13821236,
        "credentialNum":"522221195005160417",
        "treatEndDate":"20141018",
        "hospitalList":[
            {
                "hospitalName":"昆明医科大学第二附属医院",
                "hospitalCode":"400050931"
            }
        ],
        "name":"邱建翻",
        "treatBeginDate":"20140101",
        "authorizationNum":"106573194",
        "hospitalizedNum":null,
        "insCode":"100000001",
        "isUpload":true,
        "hid":"hi862LMIcSO",
        "surveyType":1,
        "authorSerialNumber":"jm4Tn8ZxiMT",
        "icpid":"1lkko80k0409"
    },
    "taskId":null,
    "insRequestObject":{
        "hid":"hi862LMIcSO",
        "hpid":"j722vNpmW6C",
        "cid":"1IAJPbLR5rD",
        "icpid":"1lkko80k0409",
        "businessCode":"84MwuriApMe",
        "businessTypeCode":3,
        "areaCode":"",
        "sendName":"调查平台",
        "sendSerial":"1539749118671",
        "reportNumber":null,
        "channelName":3,
        "medicalNum":null,
        "reqParams":{
            "credentialType":"01",
            "timeLimit":1,
            "caseNum":13821236,
            "credentialNum":"522221195005160417",
            "treatEndDate":"20141018",
            "hospitalList":[
                {
                    "hospitalName":"昆明医科大学第二附属医院",
                    "hospitalCode":"400050931"
                }
            ],
            "name":"邱建翻",
            "treatBeginDate":"20140101",
            "authorizationNum":"106573194",
            "hospitalizedNum":null,
            "insCode":"100000001",
            "isUpload":true,
            "hid":"hi862LMIcSO",
            "surveyType":1,
            "authorSerialNumber":"jm4Tn8ZxiMT",
            "icpid":"1lkko80k0409"
        },
        "busRequestId":"du34qrM2pON",
        "busRequestDetailId":null,
        "apiName":"insPrefile",
        "isScriptTest":false,
        "medicalType":null,
        "sycReturn":false,
        "thirdCode":null,
        "isTaskFinish":null,
        "reqIns":false,
        "hosReqReturn":{
            "credentialType":"01",
            "timeLimit":1,
            "caseNum":13821236,
            "credentialNum":"522221195005160417",
            "treatEndDate":"20141018",
            "hospitalList":[
                {
                    "hospitalName":"昆明医科大学第二附属医院",
                    "hospitalCode":"400050931"
                }
            ],
            "name":"邱建翻",
            "treatBeginDate":"20140101",
            "authorizationNum":"106573194",
            "hospitalizedNum":null,
            "insCode":"100000001",
            "isUpload":true,
            "hid":"hi862LMIcSO",
            "surveyType":1,
            "authorSerialNumber":"jm4Tn8ZxiMT"
        },
        "customBusTaskConfig":null,
        "task":null,
        "bid":null,
        "insExtend":{
            "head":{
                "busenissType":"6",
                "busseID":"C100",
                "clientmacAddress":"3EBB7E0A5E2D",
                "hosorgName":"admin",
                "hosorgNum":"001",
                "intermediaryCode":"",
                "intermediaryName":"",
                "receiverCode":"500000007",
                "receiverName":"乐约",
                "recordCount":"1",
                "sendTradeNum":"1539749118671",
                "senderCode":"100000001",
                "senderName":"调查平台",
                "standardVersionCode":"version1.0.0",
                "systemType":"1"
            }
        },
        "claimInfo":null,
        "returnReqHosObject":null,
        "beginTime":1539749115.0223
    }
}';

echo var_export(json_decode($str,true),true);