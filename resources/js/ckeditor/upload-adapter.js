export default class NovaCKEditorUploadAdapter {
    constructor(loader, resourceName, field, draftId) {
        this.loader = loader
        this.resourceName = resourceName
        this.field = field
        this.draftId = draftId
    }

    upload() {
        return this.loader.file
            .then( file => {
                const data = new FormData()
                data.append('Content-Type', file.type)
                data.append('attachment', file)
                data.append('draftId', this.draftId)

                const fieldName = this.field.attribute.split('.');

                return Nova.request()
                    .post(`/nova-vendor/ckeditor/${this.resourceName}/upload/${fieldName[0]}`, data, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(response => {
                        if (response.data.uploaded) {
                            return {
                                default: response.data.url
                            }
                        }
                    })
                    .catch(error => {
                        console.log(error)
                        return Promise.reject(error)
                    })
            })
    }

    abort() {

    }
}
