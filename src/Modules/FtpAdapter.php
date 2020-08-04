<?php

namespace FTPApp\Modules;

interface FtpAdapter
{
    public function openConnection();
    public function setPassive($bool);
    public function browse($dir);
}