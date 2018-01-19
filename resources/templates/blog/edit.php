<h3>Edit Blog Post</h3>

<?= $this->render('_form', [
    'method' => 'PATCH',
    'action' => '/blog/edit',
    'submit' => 'Update',
]); ?>
