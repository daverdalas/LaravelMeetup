<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\FatModel
 *
 * @property-read mixed $created_at_day_as_string
 * @property-read mixed $created_at_day
 * @property-read mixed $updated_at_month
 * @property-read mixed $updated_at_year
 * @property-write mixed $active
 * @property-write mixed $description
 * @property-write mixed $first_name
 * @property-write mixed $weight
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FatModel active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FatModel whereFirstNameLike($like)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FatModel whereWeightBetween($from, $to)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FatModel withDescription()
 */
	class FatModel extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 */
	class User extends \Eloquent {}
}

namespace App{
/**
 * App\Post
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comment[] $comments
 */
	class Post extends \Eloquent {}
}

namespace App{
/**
 * App\Comment
 *
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $commentable
 */
	class Comment extends \Eloquent {}
}

namespace App{
/**
 * App\SkinnyModel
 *
 */
	class SkinnyModel extends \Eloquent {}
}

