<?php

return [
    'serverEmail' => 'noreply@va-afl.su',
    'ivao_login_url' => 'https://login.ivao.aero/index.php?url=http://' . $_SERVER['HTTP_HOST'],
    'ivao_api_url' => 'https://login.ivao.aero/api.php?type=json&token=',
    'ivao_tools_login_url' => 'http://ivao.daitel.net/login/?url1=http://' . $_SERVER['HTTP_HOST'] .'/users/auth/login&redirect_url=' . $_SERVER['HTTP_HOST'],
    'ivao_tools_api_url' => 'http://ivao.daitel.net/login_api/?token=',
];