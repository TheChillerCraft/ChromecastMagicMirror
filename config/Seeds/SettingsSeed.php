<?php
use App\Locale\Languages;
use Cake\ORM\TableRegistry;
use Phinx\Seed\AbstractSeed;

/**
 * Settings seed.
 */
class SettingsSeed extends AbstractSeed
{
    private $_data = [];

    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     * @return void
     */
    public function run()
    {
        $category = $this->addCategory([
            'name' => 'Magic Mirror Settings',
            'short_name' => 'magic_mirror',
            'enabled' => true,
            'panel_width' => 6,
            'panel_row' => 0,
            'panel_column' => 0
        ]);

        $this->addSetting($category, [
            'name' => 'Language',
            'short_name' => 'language',
            'required' => 1,
            'default_value' => 'en',
            'options' => Languages::$languages
        ]);
        $this->addSetting($category, [
            'name' => 'Rotation',
            'short_name' => 'rotation',
            'required' => 1,
            'default_value' => 'portrait',
            'options' => [
                'Portrait',
                'Landscape'
            ]
        ]);
        $this->addSetting($category, [
            'name' => 'Time Format',
            'short_name' => 'time_format',
            'required' => 1,
            'default_value' => '12',
            'options' => [
                '12' => '12 Hour',
                '24' => '24 Hour'
            ]
        ]);
        $this->addSetting($category, [
            'name' => 'Receiver IP',
            'short_name' => 'app_id',
            'required' => 1,
            'default_value' => '5FD69FDB',
            'options' => [
                '5FD69FDB' => '192.168.1.51',
                'C8BB9A98' => '10.5.5.51',
                '9DC72911' => '172.16.1.51'
            ]
        ]);

        $category = $this->addCategory([
            'name' => 'Weather Settings',
            'short_name' => 'weather',
            'enabled' => true,
            'panel_width' => 6,
            'panel_row' => 0,
            'panel_column' => 1
        ]);

        $this->addSetting($category, [
            'name' => 'Zip Code',
            'short_name' => 'zip_code',
            'required' => 1,
            'default_value' => ''
        ]);
        $this->addSetting($category, [
            'name' => 'Units',
            'short_name' => 'units',
            'required' => 1,
            'default_value' => 'imperial',
            'options' => ['imperial', 'celsius']
        ]);
        $this->addSetting($category, [
            'name' => 'Open Weather Map API Key',
            'short_name' => 'api_key',
            'required' => 1,
            'default_value' => ''
        ]);

        $categoriesTable = TableRegistry::get('Categories');

        foreach ($this->_data as $data) {
            $category = $categoriesTable->newEntity($data, ['associated' => ['Settings']]);
            $categoriesTable->save($category);
        }
    }

    /**
     * Creates a category with the specified properties
     *
     * @param array $properties
     * @return mixed
     */
    public function addCategory($properties)
    {
        $this->_data[] = $properties;
        $keys = array_keys($this->_data);

        return end($keys);
    }

    /**
     * Creates a setting with the specified category id and properties
     *
     * @param int $category_id
     * @param array $properties
     * @return void
     */
    public function addSetting($category_id, $properties)
    {
        foreach ($properties as $key => $property) {
            if ($key == 'options' && is_array($property)) {
                $properties[$key] = serialize($property);
            }
        }

        $this->_data[$category_id]['settings'][] = $properties;
    }
}
