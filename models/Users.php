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
 * @property string $accessToken
 * @property integer $blocked
 * @property string $block_reason
 * @property integer $blocked_by
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
			[['accessToken', 'block_reason'], 'string'],
			[['full_name', 'email'], 'string', 'max' => 200],
			[['country'], 'string', 'max' => 2]
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
			'accessToken' => 'Access Token',
			'blocked' => 'Blocked',
			'block_reason' => 'Block Reason',
			'blocked_by' => 'Blocked By',
		];
	}
}
