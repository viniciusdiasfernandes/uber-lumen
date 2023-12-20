<?php

namespace Ride\Domain;

enum StatusEnum
{
    const Requested = "requested";
    const Accepted = "accepted";
    const InProgress = "in_progress";
    const Completed = "completed";
    const Cancelled = "cancelled";
}
