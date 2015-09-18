<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $vid
 * @property string $full_name
 * @property string $email
 * @property string $country
 * @property string $authKey
 * @property integer $blocked
 * @property string $block_reason
 * @property integer $blocked_by
 * @property string $language
 * @property string $created_date
 * @property string $last_visited
 */
class Users extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'users';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['vid'], 'required'],
			[['vid', 'blocked', 'blocked_by'], 'integer'],
			[['authKey', 'block_reason'], 'string'],
			[['created_date', 'last_visited'], 'safe'],
			[['full_name', 'email'], 'string', 'max' => 200],
			[['country', 'language'], 'string', 'max' => 2]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'vid' => 'Vid',
			'full_name' => 'Full Name',
			'email' => 'Email',
			'country' => 'Country',
			'authKey' => 'Auth Key',
			'blocked' => 'Blocked',
			'block_reason' => 'Block Reason',
			'blocked_by' => 'Blocked By',
			'language' => 'Language',
			'created_date' => 'Created Date',
			'last_visited' => 'Last Visited',
		];
	}
}
