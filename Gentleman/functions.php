<?php

function generateNecessaryDirAndFiles()
{
    generateEnvFile();
    generateLogsDir();
    generateAppDir();
}

const ENV_FIELDS = <<<TEXT
APP_NAME="dev"
START_POINT="index.php"
TEXT;
function generateEnvFile()
{
    if (!is_file('.env')) {
        file_put_contents('.env', ENV_FIELDS);
    }
}

function generateLogsDir()
{
    if (!is_dir('logs') && !mkdir('logs')) {
        throw new \RuntimeException(sprintf('Directory "%s" was not created', 'logs'));
    }
}

function generateAppDir()
{
    if (!is_dir('app') && !mkdir('app')) {
        throw new \RuntimeException(sprintf('Directory "%s" was not created', 'app'));
    }
}
