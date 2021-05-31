# CreateSql
If you are pulling data from the database by writing sql code, it's a nice tool to help you create where and limit queries that work in the PHP PDO library.

## Example

	$sql    = new CreateSql();
        
    $sql->createLimit	 (1, 20);
    $sql->createWhereLike('b.TITLE',       "%searchString%");
    $sql->createWhere    ('b.LAST_CONTROL', 'success');
    $sql->createWhere    ('b.ACTIVE',       'true');
    $sql->createWhere    ('b.TAX_PLATE',    'true');

    $query = "SELECT COUNT(ID) FROM businesses as b {$sql->where}";

    $stmt->prepare($query);
    $stmt->execute($sql->param);