<?php
/** Form renderer + generic save/delete helpers.
 * Field def: ['name','label','type' => text|email|tel|number|date|select|textarea|hidden,
 *             'options' => [val=>label], 'required' => bool, 'step', 'placeholder']
 */

function form_field(array $f, $val = ''): void {
    $req = !empty($f['required']) ? ' required' : '';
    $ph  = isset($f['placeholder']) ? ' placeholder="' . h($f['placeholder']) . '"' : '';
    $val = $val === null ? '' : $val;
    $type = $f['type'] ?? 'text';
    echo '<label class="fld"><span>' . h($f['label']) . '</span>';
    switch ($type) {
        case 'hidden':
            echo '<input type="hidden" name="' . h($f['name']) . '" value="' . h($val) . '">';
            break;
        case 'textarea':
            echo '<textarea name="' . h($f['name']) . '"' . $req . $ph . '>' . h($val) . '</textarea>';
            break;
        case 'select':
            echo '<select name="' . h($f['name']) . '"' . $req . '>';
            foreach (($f['options'] ?? []) as $ov => $ol) {
                $sel = ((string)$val === (string)$ov) ? ' selected' : '';
                echo '<option value="' . h($ov) . '"' . $sel . '>' . h($ol) . '</option>';
            }
            echo '</select>';
            break;
        default:
            $step = isset($f['step']) ? ' step="' . h($f['step']) . '"' : '';
            echo '<input type="' . h($type) . '" name="' . h($f['name']) . '" value="' . h($val) . '"' . $req . $ph . $step . '>';
    }
    echo '</label>';
}

function render_form(array $fields, array $row = [], string $btn = 'Save'): void {
    echo '<form method="POST" class="form-grid">' . csrf_field();
    foreach ($fields as $f) form_field($f, $row[$f['name']] ?? '');
    echo '<div class="form-actions"><button class="btn btn-acc" type="submit">' . h($btn) . '</button></div></form>';
}

/** Saves POST into $table for given column names. Returns id. */
function form_save(array $app, string $table, array $cols, ?int $id = null): int {
    $data = [];
    foreach ($cols as $c) $data[] = postv($c) === '' ? null : postv($c);
    $db = $app['db'];
    if ($id) {
        $set = implode('=?, ', $cols) . '=?';
        q($app, "UPDATE $table SET $set WHERE id=?", array_merge($data, [$id]));
        return $id;
    }
    $marks = rtrim(str_repeat('?,', count($cols)), ',');
    q($app, "INSERT INTO $table (" . implode(',', $cols) . ") VALUES ($marks)", $data);
    return (int) $db->lastInsertId();
}

/** Deletes row if POST delete_id present. Returns true when deleted. */
function maybe_delete(array $app, string $table): bool {
    $id = (int) postv('delete_id');
    if ($id > 0) { q($app, "DELETE FROM $table WHERE id=?", [$id]); return true; }
    return false;
}

/** Renders an edit link + inline delete form for a row. */
function row_actions(string $editUrl, int $id): string {
    return '<div class="row-actions">'
        . '<a class="btn btn-sm" href="' . h($editUrl) . '">Edit</a>'
        . '<form method="POST" class="inline" onsubmit="return confirm(\'Delete this record?\')">'
        . csrf_field()
        . '<input type="hidden" name="delete_id" value="' . $id . '">'
        . '<button class="btn btn-sm btn-danger" type="submit">Delete</button></form></div>';
}

/**
 * One-call generic CRUD page: handles save/delete POST, edit load,
 * then renders the add/edit form + listing table.
 *
 * $cfg = [
 *   'title'    => 'Patients',
 *   'table'    => 'patients',
 *   'fields'   => [ ['name'=>..,'label'=>..,'type'=>..,'options'=>..], ... ],
 *   'list_sql' => 'SELECT ...',           // optional, defaults to SELECT * ORDER BY id DESC
 *   'columns'  => [ 'Header' => fn($row)=>html, ... ],
 *   'extra'    => fn($post)=>[],          // optional extra insert values
 * ]
 */
function crud_page(array $app, array $cfg): void {
    $table  = $cfg['table'];
    $self   = basename($_SERVER['PHP_SELF']);
    $fields = $cfg['fields'];
    $names  = array_values(array_filter(array_column($fields, 'name'), fn($n) => $n !== 'id'));

    if (is_post()) {
        csrf_check();
        if (maybe_delete($app, $table)) {
            flash($cfg['title'] . ' entry deleted.');
        } else {
            $id   = postv('id') ? (int)postv('id') : null;
            $data = [];
            foreach ($names as $c) $data[$c] = postv($c) === '' ? null : postv($c);
            if (isset($cfg['extra'])) $data = array_merge($data, call_user_func($cfg['extra'], $_POST));
            $cols = array_keys($data);
            if ($id) {
                q($app, "UPDATE {$table} SET " . implode('=?,', $cols) . '=? WHERE id=?',
                    array_merge(array_values($data), [$id]));
            } else {
                q($app, "INSERT INTO {$table} (" . implode(',', $cols) . ') VALUES (' .
                    rtrim(str_repeat('?,', count($cols)), ',') . ')', array_values($data));
            }
            flash($cfg['title'] . ' entry saved.');
        }
        redirect($self);
    }

    $edit = getv('edit') ? q1($app, "SELECT * FROM {$table} WHERE id=?", [(int)getv('edit')]) : [];
    $rows = qa($app, $cfg['list_sql'] ?? "SELECT * FROM {$table} ORDER BY id DESC");

    page_head($app, $cfg['title']);
    echo '<div class="card"><div class="card-head"><h2>' . h($edit ? 'Edit' : 'Add') . ' ' . h($cfg['title']) . '</h2></div><div class="card-body">';
    render_form($fields, $edit ?: [], ($edit ? 'Update' : 'Add') . ' ' . h($cfg['title']));
    echo '</div></div><div class="card"><div class="card-head"><h2>All ' . h($cfg['title']) . ' (' . count($rows) . ')</h2></div><div class="card-body" style="padding:0;"><table class="tbl"><tr>';
    foreach (array_keys($cfg['columns']) as $h2) echo '<th>' . h($h2) . '</th>';
    echo '<th></th></tr>';
    if (!$rows) echo '<tr><td colspan="' . (count($cfg['columns']) + 1) . '" class="empty">No records yet</td></tr>';
    foreach ($rows as $r) {
        echo '<tr>';
        foreach ($cfg['columns'] as $cell) echo '<td>' . $cell($r) . '</td>';
        echo '<td>' . row_actions("{$self}?edit={$r['id']}", $r['id']) . '</td></tr>';
    }
    echo '</table></div></div>';
    page_foot();
}
