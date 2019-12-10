### 介绍
Excel文件生成及Excel文件读取

### 用法

#### ListBuilder

+ 生成单个sheet的excel文件
```php
$options  = [
    'row_count' => 500,    //excel生成的行数
    'headers' => [
        [
            'title' => '读者编号',
        ],
        [
            'title' => '姓名',
        ],
        [
            'title' => '性别',
            'type' => 'list',
            'data_source' => '女,男'
        ],
        [
            'title' => '读者类型',
            'type' => 'list',
            'data_source' => '高年级学生,低年级学生,老师'
        ],
        [
            'title' => '读者状态',
            'type' => 'list',
            'data_source' => '停用,正常,注销,挂失'
        ],
        [
            'title' => '注册日期'
        ],
        [
            'title' => '学号'
        ]
    ]
];

//列表数据
//次序与类型必须与options对应
$data = [
    'DD123456',
    '张三',
    '女',
    '高年级学生',
    '停用',
    '2016-07-10',
    'G44532220060903492X'
];
$excel = new \QsExcel\Excel();
$excel->addBuild(new \QsExcel\Builder\ListBuilder($options, $data));
$excel->output('reader_import.xlsx');

```

+ 生成多个sheet的excel文件
```php
//大数组数据，总字符串长度超过565，将会自动生成数据源sheet进行存储
$project_arrs = [
    .
    .
    .
];

$book_arrs = [
    .
    .
    .
];

$options  = [
    'row_count' => 500,
    'headers' => [
        [
            'title' => '读者编号',
        ],
        [
            'title' => '姓名',
        ],
        [
            'title' => '性别',
            'type' => 'list',
            'data_source' => '女,男'
        ],
        [
            'title' => '项目',
            'type' => 'list',
            'data_source' => implode(',', $project_arrs)
        ],
        [
            'title' => '推荐书籍',
            'type' => 'list',
            'data_source' => implode(',', $book_arrs)
        ],
        [
            'title' => '注册日期'
        ],
        [
            'title' => '学号'
        ]
    ]
];

$options1  = [
    'row_count' => 500,
    'headers' => [
        [
            'title' => '读者姓名',
        ],
        [
            'title' => '学校',
        ],
        [
            'title' => '性别',
            'type' => 'list',
            'data_source' => '女,男'
        ],
        [
            'title' => '项目',
            'type' => 'list',
            'data_source' => implode(',', $project_arrs)
        ],
        [
            'title' => '注册日期'
        ],
        [
            'title' => '学号'
        ]
    ]
];

$excel = new \QsExcel\Excel();
$excel->addBuild((new \QsExcel\ListBuilder($options))->setSheetName('test'));
$excel->addBuild((new \QsExcel\ListBuilder($options1))->setSheetName('test1'));
$excel->output('reader_import.xlsx');

```

####  ListLoader
```php
$file = __DIR__ . '/excel.xls';  
$excel = new Excel();
//需要读取多少个sheet的数据，则设置多少个loader，可根据不同的sheet类型来针对性的设置不同的loader类型
//默认第一个loader读取index为0的sheet 第二个读取index为1的sheet，以此类推
$excel->setLoadFile($file);
$excel->addLoader(new ListLoader());
$excel->addLoader(new ListLoader());
$excel->addLoader(new ListLoader());
$excel->addLoader(new ListLoader());
$list = $excel->load(); 
```
