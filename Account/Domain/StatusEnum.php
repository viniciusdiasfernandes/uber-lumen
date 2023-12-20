<?php

namespace Account\Domain;

enum StatusEnum
{
    const Created = "created";
    const Active = "active";
    const Forgotten = "forgotten";
}
