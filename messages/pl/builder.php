<?php
#Copyright (c) 2016-2017 Rafal Marguzewicz pceuropa.net

#1.1.1
return [
    'Form Builder' => 'Form budowniczy',  
    'Form' => 'Formularz',  
    'Field' => 'Pole',  
    'Input' => 'Pole tekstowe',  
    'TextArea' => 'Pole tekstowe wieloliniowe',  
    'Radio' => 'Pole jednokrotnego wyboru (radio)',  
    'Checkbox' => 'Pole wielokrotnego wyboru',  
    'Select' => 'Pole jednokrotnego wybory (select)',  
    'Description' => 'Opis',  
    'Submit Button' => 'Guzik zatwierdź',
      
    'View' => 'Widok',  
    'Title' => 'Tytuł',  
    'Text' => 'Tekst',  
    'Save Form' => 'Zapisz formularz',  
    'Name' => 'Nazwa',  
    'Type' => 'Typ',  
    
    'text' => 'tekst',
    'email' => 'email',
    'password' => 'hasło',
    'date' => 'data',
    'number' => 'liczba',
    'phone' => 'telefon',
    'color' => 'kolor',
    'range' => 'zakres',
    
    'Label' => 'Etykieta',  
    'Placeholder' => 'Tekst zastępczy',  
    'Width' => 'Szerokość',  
    'Value' => 'Tekst domyślny',  
    'Value item' => 'Wartość',  
    'Field require' => 'wymagane',  
    'Rows' => 'Ilość wierszy',  
    'Add to form' => 'Dodaj do formularza',  
    'Add item' => 'Dodaj do pola',  
    'Items' => 'Elementy pola',  
    'Checked' => 'Zaznaczony',  
    'Selected' => 'Domyślnie wybrany',  
    'Method' => 'Metoda wysyłki',  
    'Action' => 'Adres odbioru',  
    'Template' => 'Szablon',  
    'Address URL' => 'Adres URL',
    
    'Preview field' => 'Podgląd pola',  
    
// manual   
    'Manual' => 'Podręcznik',  
    'Form options (right column)' => 'Opcje formularza (kolumna prawa)',  
    '<b>View</b> changes the color of a displayed code' => '<b>Widok</b> zmienia rodzaj wyświetlanego kodu',  
    '<b>Title</b> does not appear in a form code, is used for differentiation in a list of forms. If you need a title, use Field -> Description' => '<b>Tytuł</b> nie pojawia się w kodzie formularza, służy do rozróżnienia w liście formularzy. Jeżeli potrzebujesz tytułu skorzystaj z Pole -> Opis',  
    '<b>URL address</b> the URL address of a form' => '<b>Adres URL</b> adres URL formularza',  
    '<b>Method (HTTP)</b> a way of data transmission between a form and a collection address' => '<b>Metoda wysyłki</b> sposób przekazywania danych pomiędzy formularzem a adresem odbioru',  
    '<b>Action</b> leave blank if the URL collection address is the same as the address of a form' => '<b>Adres odbioru</b> zostaw puste jeżeli adres URL odbioru jest taki sam jak adres formularza ',  
    '<b>ID</b> allows setting an id attribute for a form, practicable for CSS' => '<b>ID</b> pozwala ustawić atrybut id dla formularza, przydatne do CSS',  
    '<b>Class</b> allows setting a class attribute for a form, practicable for CSS' => '<b>Class</b> pozwala ustawić atrybut class dla formularza, przydatne do CSS',  
    '<b>Save the form</b> an option for saving a form which is active upon filling the title and URL address fields' => '<b>Zapisz formularz</b> opcja zapisania formularza aktywna po wypełnieniu pól tytuł i adres URL',  
    
    '<b>Field options</b>' => '<b>Opcje pola</b>',  
    '<b>Selection menu</b> allows to choose a particular element' => '<b>Menu wyboru</b> pozwala wybrać dany element',  
    '<b>Name</b> an attribute not visible in the form, required for differentiation of received data from filled forms' => '<b>Nazwa</b> atrybut nie widoczny w formularzu, potrzebny do rozróżnienia otrzymywanych danych z wypełnionych danych',  
    '<b>Label</b> a writing appearing above a field' => '<b>Etykieta</b> napis pojawiający się nad polem',  
    '<b>Placeholder</b> tekst a description of a form field, localized in the field that disappears after you have started to fill in a given field' => '<b>Tekst zastępczy</b> opis pola formularza, ulokowany w polu, który znika po rozpoczęciu wypełniania danego pola formularza',  
    '<b>Default</b> text a field filled in automatically' => '<b>Tekst domyślny</b> domyślnie wypełnione pole',  
    '<b>Description</b> a descriptive text localized above a field' => '<b>Opis</b> tekst opisowy ulokowany pod polem',  
    '<b>Width</b> a field may be of e.g. 50% width and then 2 fields may appear on a computer screen in a line. The field on a smart phone screen is always of 100% width' => '<b>Szerokość</b> pole może mieć szerokość np 50% w tedy na ekranie komputera mogą być 2 pola w jednej linii. Na ekranie smartfona pole zawsze ma szerokość 100% ',  
    '<b>Required</b> a form field must be filled in' => '<b>Wymagane</b> pole formularza musi być uzupełnione',  
    '<b>ID</b> allows setting an id attribute for a form, practicable for CSS' => '<b>ID</b> pozwala ustawić atrybut id dla formularza, przydatne do CSS',  
    '<b>Class</b> allows setting a class attribute for a form, practicable for CSS' => '<b>Class</b> pozwala ustawić atrybut class dla formularza, przydatne do CSS',  
    
    '<b>Field elements</b> in case of multiple choice fields' => '<b>Elementy</b> pola w przypadku pól wielokrotnego wyboru',  
    '<b>Text</b> text of one element from a field list' => '<b>Text</b> tekst jednego elementu z listy pola',  
    '<b>Value</b> will allow the differentiation of answers, leave blank if you are not sure, the system will paginate automatically' => '<b>Wartość</b> pozwoli rozróżnić odpowiedzi, zostaw puste jeżeli niemasz pewności, system ponumeruje automatycznie',  
    '<b>Checked</b> an element of a field list selected automatically' => '<b>Zaznaczone</b> element listy pola domyślnie wybrany',  
    
    'This application allows to easily create Internet forms which may then be made available to be filled in by others. Such generated form allows to versify entered data and record them in a data base or a spreadsheet.' => 'Aplikacja pozwala tworzyć łatwo formularze internetowe,  które następnie możesz udostępniać innym do wypełniania. Tak wygenerowany formularz pozwala na wersyfikację wpisywanych danych oraz zapisywanie ich w bazie danych lub arkuszu kalkulacyjnym.',  
    'You may also generate only a form code (html, yii2, json) and embed it into your application or website. By means of the “form builder” you can create contact and login forms, surveys and many others. ' => 'Możesz również generować jedynie kod formularza( html, yii2, json) i osadzić go w twojej aplikacji lub stronie www. Za pomocą „form budowniczy” możesz tworzyć formularze kontaktowe, logowania, ankiety i wiele innych.',  
    '' => '',  
   
];

