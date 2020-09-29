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

function generate404()
{
    if (!is_dir('var') && !mkdir('var')) {
        throw new \RuntimeException(sprintf('Directory "%s" was not created', 'logs'));
    }

    $notFound = <<<text
    <?php
    echo '404 error';
    text;

    file_put_contents('var/404.php', $notFound);
    
    return 'var/404.php';
}
