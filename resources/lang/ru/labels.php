<?php

return [
    'general' => [
        'yes' => 'Да',
        'no' => 'Нет',
        'created_at' => 'Создано',
    ],

    'filters' => [
        'answer' => 'Было ли полезно',
        'created_from' => 'Создано с',
        'created_until' => 'Создано до',
        'has_comment' => 'Есть комментарий',
        'has_email' => 'Есть Email',
        'has_options' => 'Выбраны варианты',
        'options' => 'Варианты',
        'option' => 'Вариант',
        'url' => 'URL',
        'period' => 'Период',
        'today' => 'Сегодня',
        'yesterday' => 'Вчера',
        'week' => 'Неделя',
        'last_month' => 'Последний месяц',
        'last_3_months' => 'Последние 3 месяца',
        'custom' => 'Произвольный период',
        'select_period' => 'Выберите период',
    ],

    'periods' => [
        'today' => 'Сегодня',
        'yesterday' => 'Вчера',
        'current_week' => 'Прошлая неделя',
        'previous_week' => 'Предыдущая неделя',
        'current_month' => 'Текущий месяц',
        'previous_month' => 'Предыдущий месяц',
        'current_year' => 'Текущий год',
        'previous_year' => 'Предыдущий год',
    ],

    'options' => [
        'resolved_my_issue' => 'Решило мою проблему',
        'clear_instructions' => 'Понятные инструкции',
        'easy_to_follow' => 'Легко следовать',
        'no_jargon' => 'Без жаргона',
        'no_mistakes' => 'Без ошибок',
        'pictures_helped' => 'Изображения помогли',
        'other' => 'Другое',
        'article_is_outdated' => 'Статья устарела',
        'incorrect_instructions' => 'Некорректные инструкции',
        'too_technical' => 'Слишком технический текст',
        'not_enough_information' => 'Недостаточно информации',
        'not_enough_pictures' => 'Недостаточно изображений',
        'too_many_grammar_mistakes' => 'Много грамматических ошибок',
        'bad_color_scheme' => 'Неудобный дизайн сайта',
    ],

    'language_scores' => [
        'very_unsatisfied' => 'Очень не удовлетворен',
        'unsatisfied' => 'Не удовлетворен',
        'neutral' => 'Нейтрально',
        'satisfied' => 'Удовлетворен',
        'very_satisfied' => 'Очень удовлетворен',
    ],

    'pages' => [
        'overview' => [
            'title' => 'Обзор',
        ],
    ],

    'metadata' => [
        'metadata_fieldset' => 'Метаданные',
        'ip' => 'IP-адрес',
        'os' => 'Операционная система',
        'country' => 'Страна',
        'device' => 'Устройство',
        'browser' => 'Браузер',
        'language' => 'Язык',
        'user_agent' => 'User Agent',
        'duration' => 'Длительность',
    ],

    'actions' => [
        'remove' => 'Удалить',
        'overview' => 'Обзор',
        'code' => 'Код'
    ],
    'resources' => [
        'feedback' => [
            'navigation_group' => 'Обратная связь',
            'navigation_label' => 'Все ответы',
            'record_label' => 'Обратная связь',
            'record_plural_label' => 'Обратная связь',
            'main_fieldset' => 'Обратная связь',
            'url' => 'Url',
            'answer' => 'Ответ',
            'options' => 'Варианты',
            'language_score' => 'Оценка качества языка',
            'comment' => 'Комментарий',
            'email' => 'Email',
        ],

        'feedback_stats' => [
            'navigation_group' => 'Обратная связь',
            'navigation_label' => 'Статистика',
            'record_label' => 'Обратная связь',
            'record_plural_label' => 'Обратная связь',
            'url' => 'Url',
            'total' => 'Всего',
            'yes_count' => 'Ответов "Да"',
            'no_count' => 'Ответов "Нет"',
            'options' => 'Варианты',
            'avg_score' => 'Средняя оценка языка',
            'language_scores' => 'Оценки языка',
            'comments' => 'Комментарии',
            'total_feedback_count' => 'Всего ответов',
            'selected_options_count' => 'Ответы с выбранными вариантами',
            'feedback_answers' => 'Обратная связь',
        ],

        'report' => [
            'navigation_group' => 'Сообщения об ошибках',
            'navigation_label' => 'Все сообщения',
            'record_label' => 'Сообщение',
            'record_plural_label' => 'Сообщения',
            'main_fieldset' => 'Сообщение',
            'url' => 'Url',
            'full_text' => 'Полный текст',
            'diff_text' => 'Исправленный текст',
            'comment' => 'Комментарий',
            'email' => 'Email',
        ],

        'report_stats' => [
            'navigation_group' => 'Сообщения об ошибках',
            'navigation_label' => 'Статистика',
            'record_label' => 'Сообщение',
            'record_plural_label' => 'Сообщения',
            'url' => 'Url',
            'total' => 'Всего',
            'has_comment_count' => 'Сообщений с комментарием',
            'total_reports_count' => 'Всего сообщений',
            'archived_reports_count' => 'Архивированные сообщения',
        ],

        'sites' => [
            'navigation_label' => 'Сайты',
            'record_label' => 'Сайт',
            'record_plural_label' => 'Сайты',
            'code' => 'Код',
            'name' => 'Название',
            'domain' => 'Домен',
            'settings' => 'Настройки',
            'feedback_enabled' => 'Обратная связь включена',
            'reports_enabled' => 'Сообщения об ошибках включены',
            'id' => 'ID',
            'last_event' => 'Последнее событие',
            'reports_count' => 'Количество сообщений',
            'feedback_count' => 'Обратная связь',
        ]
    ],

    'code_viewer' => [
        'report_anchor_label' => 'ID контейнера сообщения об ошибке',
        'feedback_anchor_label' => 'ID контейнера попапа обратной связи',
        'generated_code_label' => 'Сгенерированный код',
        'copy_code' => 'Копировать код',
        'report_anchor_placeholder' => 'Введите ID элемента для формы сообщения',
        'feedback_anchor_placeholder' => 'Введите ID элемента для попапа обратной связи',
        'copied' => 'Скопировано!',
    ]
];


