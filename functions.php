<?php

const ENV_FIELDS = <<<TEXT
APP_NAME=""
TEXT;

function generateEnvFile()
{
    file_put_contents('.env', ENV_FIELDS);
}
