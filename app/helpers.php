<?php


function currentUser() : ?\App\Models\User
{
    return auth()->user();
}