<?php foreach ($this->blogs as $blog) {
    echo $this->render('_intro', ['blog' => $blog]);
} ?>
