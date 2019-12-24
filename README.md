### 安装
```php
composer require tiderjian/qs-excel
```

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

##### Cell Type

ListTypeBuilder 将单元格设置成下拉列表,支持三种设置数据源的方式

> 1. 短字符串
>> 短字符串的含义是小于565个字符，此时短字符串会直接设置为列表数据源，不会有额外的表格内容占用, 内容用","分隔。
```php
[
    'title' => '性别',
    'type' => 'list',
    'data_source' => '男,女'
]
```

> 2. 长字符串
>> 长字符串是相对于短字符串而言的，也就是大于565个字符，此时qs-excel会自动生成一个名字为ListSource的sheet用于存放数据源
```php
$arr = []; //大数组
[
    'title' => '性别',
    'type' => 'list',
    'data_source' => implode(',', $arr)
]
```

> 3. 指定引用源
>> qs-excel 支持以 "sheet!$A$1:$A$20" 这种格式的方式设置任意表格的引用数据源
```php
[
    'title' => '团队名',
    'type' => 'list',
    'data_source' => '团队信息!$B$2:$B$500'   // 团队信息为其他sheet的sheet名，前后两个列字母的必须一致，这个例子就是B
]
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
