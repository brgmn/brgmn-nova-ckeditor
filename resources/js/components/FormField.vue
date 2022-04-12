<template>
  <DefaultField
      :field="field"
      :errors="errors"
      :full-width-content="true"
      :show-help-text="showHelpText"
  >
    <template #field>
      <div class="rounded-lg" :class="{ disabled: isReadonly }">
        <ckeditor
            :editor="editor"
            :config="editorConfig"
            :id="field.name"
            :class="errorClasses"
            :placeholder="field.name"
            v-model="value"
            @ready="setEditorInitialValue"
        />
      </div>
    </template>
  </DefaultField>
</template>

<script>
import CKEditor from '@ckeditor/ckeditor5-vue'
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
import NovaCKEditorUploadAdapter from '../ckeditor/upload-adapter'
import {FormField, HandlesValidationErrors} from 'laravel-nova'
import {v4 as uuidv4} from 'uuid';

export default {
  mixins: [FormField, HandlesValidationErrors],

  components: {
    ckeditor: CKEditor.component
  },

  data() {
    return {
      editor: ClassicEditor,
      defaultEditorConfig: {
        nova: {
          resourceName: this.resourceName,
          field: this.field,
          draftId: uuidv4()
        },
        language: 'en',
        toolbar: this.field.options.toolbar,
        heading: this.field.options.heading,
        image: this.field.options.image,
        fontFamily: this.field.options.fontFamily,
        extraPlugins: [
          this.createUploadAdapterPlugin
        ],
        link: this.field.options.link
      }
    }
  },

  computed: {
    draftId: function () {
      return this.defaultEditorConfig.nova.draftId
    },
    editorConfig: function () {
      let editorConfig = this.defaultEditorConfig

      if (!editorConfig.nova.field.withFiles) {
        editorConfig.removePlugins = [
          'Image',
          'ImageToolbar',
          'ImageCaption',
          'ImageStyle',
          'ImageTextAlternate',
          'ImageUpload'
        ]
        editorConfig.image = {}
        editorConfig.extraPlugins = []
      }

      return editorConfig
    }
  },

  beforeDestroy() {
    this.cleanUp()
  },

  methods: {
    /**
     * Set the initial, internal value for the field.
     */
    setInitialValue() {
      //
    },

    /**
     * Set the editor initial, internal value for the field when the editor is ready.
     */
    setEditorInitialValue(editor) {
      this.value = this.field.value || ''
    },

    /**
     * Fill the given FormData object with the field's internal value.
     */
    fill(formData) {
      formData.append(this.field.attribute, this.value || '')
      formData.append(this.field.attribute + 'DraftId', this.draftId);
    },

    /**
     * Update the field's internal value.
     */
    handleChange(value) {
      this.value = value
    },

    /**
     * Create CKEditor upload adapter plugin.
     */
    createUploadAdapterPlugin(editor) {
      let novaConfig = editor.config.get('nova')

      editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
        return new NovaCKEditorUploadAdapter(loader, novaConfig.resourceName, novaConfig.field, novaConfig.draftId)
      }
    },

    /**
     * Purge pending attachments for the draft
     */
    cleanUp() {
      if (this.field.withFiles) {
        Nova.request()
            .delete(
                `/nova-vendor/ckeditor/${this.resourceName}/attachments/${this.field.attribute}/${this.draftId}`
            )
            .then(response => console.log(response))
            .catch(error => {
            })
      }
    }

  }
}
</script>
