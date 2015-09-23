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
	const SCENARIO_EDIT = 'editprofile';

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'users';
	}

	public function scenarios()
	{
		$scenarios = parent::scenarios();
		$scenarios[self::SCENARIO_DEFAULT] = ['vid'];
		$scenarios[self::SCENARIO_EDIT] = ['vid', 'email','language'];

		return $scenarios;
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['vid'], 'required'],
			[['email','language'], 'required', 'on' => self::SCENARIO_EDIT],
			[['vid', 'blocked', 'blocked_by'], 'integer'],
			[['authKey', 'block_reason'], 'string'],
			[['created_date', 'last_visited','language'], 'safe'],
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
			'full_name' => Yii::t('user','Full Name'),
			'email' => 'Email',
			'country' => Yii::t('user','Country'),
			'authKey' => 'Auth Key',
			'language' => Yii::t('user','Language'),
			'created_date' => 'Created Date',
			'last_visited' => 'Last Visited',
		];
	}
}
