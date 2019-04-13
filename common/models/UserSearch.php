<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class UserSearch extends User
{

    public $firstname;
    public $lastname;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'sponsor_id', 'created_at', 'updated_at'], 'integer'],
            [['username', 'email', 'firstname', 'lastname', 'auth_key', 'password_hash', 'password_reset_token', 'verification_token'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find();

        $query->joinWith(['profile']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'username',
                'firstname' => [
                    'asc' => ['user_profile.firstname' => SORT_ASC],
                    'desc' => ['user_profile.firstname' => SORT_DESC],
                    'label' => '-First Name-'
                ],
                'lastname' => [
                    'asc' => ['user_profile.lastname' => SORT_ASC],
                    'desc' => ['user_profile.lastname' => SORT_DESC],
                    'label' => '-Last Name-'
                ],
                'email',
                'status',
                'sponsor_id',
                'created_at'
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            // $query->joinWith(['profile']);
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'sponsor_id' => $this->sponsor_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'verification_token', $this->verification_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'user_profile.firstname', $this->firstname])
            ->andFilterWhere(['like', 'user_profile.lastname', $this->lastname])
            ;

        return $dataProvider;
    }
}
