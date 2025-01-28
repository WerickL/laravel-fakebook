<?php 

enum PostStatusEnum: string
{
    case Draft = "D";
    case Published = "P";
    case Archived = "A";
    case Deleted = "DEL";
    case Scheduled = "S";
    case PendingApproval = "PA";
    case Rejected = "R";
    case Privated = "PR";
}