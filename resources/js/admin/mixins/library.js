import Library from '../components/library/Popin'
import FileInfo from '../components/library/FileInfo'

export default {
    data () {
        const openLibrary = this.openLibrary

        return {
            libraryOpen: false,
            libraryContext: null,
            activeFile: null
        }
    },
    components: {
        Library, FileInfo
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
