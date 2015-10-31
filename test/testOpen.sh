#!/bin/sh


host='http://localhost'


# genurl 
genurl()
{

    echo  "$host/hce/open?sessionkey=$sessionkey&productno=$productno&imei=$imei&accesstoken=$accesstoken"
    echo  "$host/hce/sync?sessionkey=$sessionkey&productno=$productno&imei=$imei&accesstoken=$accesstoken"
    echo  "$host/hce/sync?sessionkey=$sessionkey&productno=$productno&imei=$imei&accesstoken=$accesstoken"
    echo  "$host/hce/sync?sessionkey=$sessionkey&productno=$productno&imei=$imei&accesstoken=$accesstoken"
}

#sync state, update accesstoken.
http://localhost/hce/sync?sessionkey=234141414124&productno=15511112222&imei=1424124122342134124&accesstoken=cd3f37fad6e90645d55e3a4668aeb7df



http://localhost/hce/open?sessionkey=234141414124&productno=15521115166&imei=1414124122342034124&state=0

http://localhost/token/update/?accesstoken=cd3f37fad6e90645d55e3a4668aeb7df

http://localhost/token/query/?token=cd3f37fad6e90645d55e3a4668aeb7df


