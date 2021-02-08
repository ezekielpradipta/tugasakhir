<?php
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

const IMAGE_FOLDER = '/img';

function getImageUrl($image)
{
    return asset(IMAGE_FOLDER).'/'.$image;
}
