export default {
    data () {
        const openLibrary = this.openLibrary

        return {
            libraryOpen: false,
            libraryContext: null,
            tinyInit: {
                height: 500,
                menubar: false,
                content_css: '/back/css/editor.css',
                body_class: 'tinymce-editor content',
                plugins: [
                    'autolink lists link anchor',
                    'media table paste code noneditable'
                ],
                toolbar: 'undo redo | styleselect | layouts | bold italic underline | link | alignleft aligncenter alignright | bullist numlist | image media | removeformat | code',
                style_formats: [
                    {
                        title: 'Headings',
                        items: [
                            {title: 'Heading 1', format: 'h2'},
                            {title: 'Heading 2', format: 'h3'},
                            {title: 'Heading 3', format: 'h4'},
                            {title: 'Heading 4', format: 'h5'}
                        ]
                    },
                    {
                        title: 'Blocks',
                        items: [
                            {title: 'Intro', block: 'div', wrapper: true, classes: 'intro'},
                            {title: 'Quote', block: 'blockquote', wrapper: true},
                            {title: 'Paragraph', block: 'p'}
                        ]
                    }
                ],
                link_class_list: [
                    {title: 'Normal', value: ''},
                    {title: 'Button', value: 'button'}
                ],
                oninit: 'setPlainText',
                setup: (editor) => {
                    editor.on('change', () => {
                        this.hasChanged = true
                    })

                    editor.ui.registry.addButton('image', {
                        icon: 'image',
                        tooltip: "Insert image from library",
                        onAction: () => {
                            openLibrary('editor')
                        }
                    })
                }
            }
        }
    },
    methods: {
        openLibrary (context) {
            this.libraryOpen = true
            this.libraryContext = context
        },
        openFile (file) {
            this.activeFile = file
        }
    }
}
