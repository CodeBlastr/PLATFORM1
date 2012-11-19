<?php
/**
 * Sluggable Behavior
 *
 * @package model
 * @subpackage model.behaviors
 */
class SluggableBehavior extends ModelBehavior {

/**
 * Settings to configure the behavior
 *
 * @var array
 */
	public $settings = array();

/**
 * Default settings
 *
 * foreignKey	- The relationship field
 *
 * @var array
 */
	protected $_defaults = array(
        'plugin' => '', // updateed in setup
        'controller' => '', // updated in setup
		'action' => 'view',
        'foreignKey' => 'id' // field to put in the Alias.value column
        );

/**
 * Initiate behaviour
 *
 * @param object $Model
 * @param array $settings
 */
	public function setup(Model $Model, $settings = array()) {
        $this->_defaults['plugin'] = Inflector::tableize(ZuhaInflector::pluginize($Model->name));
        $this->_defaults['controller'] = Inflector::tableize($Model->name);
		$this->settings[$Model->alias] = array_merge($this->_defaults, $settings);
	}
    
    public function beforeFind(Model $Model, $query) {
        $Model->bindModel(array(
            'hasOne' => array(
                'Alias' => array(
                    'className' => 'Alias',
                    'foreignKey' => 'value',
                    'dependent' => true,
                    'conditions' => '',
                    'fields' => '',
                    'order' => 'Alias.modified DESC'
                    )
                )
            ));
        $query['contain'][] = 'Alias';
        
        return parent::beforeFind($Model, $query);
    }

/**
 * beforeValidate callback
 *
 * @param object $Model
 */
	public function beforeValidate(Model $Model) {
		if (!empty($Model->data['Alias']['name'])) {
            $this->makeUniqueSlug($Model);
            unset($Model->data['Alias']);
        }
		return true;
	}

/**
 * beforeSave callback
 *
 * @param object $Model
 * @todo bind the model here if not bound already
 */
	public function beforeSave(Model $Model, $options) {
		if (!empty($Model->data['Alias']['name'])) {
            $this->data['Alias'] = $Model->data['Alias'];
        }
        unset($Model->data['Alias']);
		return parent::beforeSave($Model, $options);
	}

/**
 * afterSave callback
 * 
 * @param Model $Model
 * @param bool $created
 */
    public function afterSave(Model $Model, $created) {
        if (!empty($this->data['Alias']['name'])) {
            $settings = $this->settings[$Model->alias];
            $this->Alias = ClassRegistry::init('Alias');
            $this->data['Alias']['value'] = $Model->data[$Model->alias][$settings['foreignKey']];
            $this->data['Alias']['name'] = $this->aliasName;
			$this->data['Alias']['plugin'] = $settings['plugin'];
			$this->data['Alias']['controller'] = $settings['controller'];
			$this->data['Alias']['action'] = $settings['action'];
            if ($this->Alias->save($this->data)) {
                // nothing just continue through
            } else {
                throw new Exception(__('Alias save failed after %s was saved.', $Model->alias));
            }
        }
        parent::afterSave($Model, $created);
    }

/**
 * Make Unique Slug
 * 
 * @param Model $Model
 * @return int
 */
    public function makeUniqueSlug(Model $Model) {
		$this->Alias = ClassRegistry::init('Alias');
        
        $names[] = $Model->data['Alias']['name'];
        for($i = 0; $i < 10; $i++){
            $names[] = $Model->data['Alias']['name'] . $i;
        }
		
        $count = $this->Alias->find('count', array('conditions' => array('Alias.name' => $names), 'fields' => 'Alias.id'));
        
        return !empty($count) ? $this->aliasName = $Model->data['Alias']['name'] . $count : $this->aliasName = $Model->data['Alias']['name'];
    }
    
}
