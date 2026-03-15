<template>
  <div>
    <v-label v-if="label" class="mb-2 d-block" :for="name">{{ label }}</v-label>

    <QuillEditor
      :id="name"
      ref="quillEditor"
      v-model:content="fieldValue"
      contentType="html"
      :options="editorOptions"
      theme="snow"
      :readOnly="disabled"
    />

    <div v-if="errorMessage" class="text-error text-caption mt-1 ml-3">
      {{ errorMessage }}
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed, ref, onMounted } from "vue";
import { useField } from "vee-validate";
import { useCardStore } from "@/modules/home/stores/CardStore";
import { useColumnStore } from "@/modules/home/stores/ColumnStore";
import { storeToRefs } from "pinia";

const cardStore = useCardStore();
const columnStore = useColumnStore();
const { getCurrentCard } = storeToRefs(columnStore);
const quillEditor = ref(null);

interface ITextEditorProps {
  name: string;
  label?: string;
  placeholder?: string;
  disabled?: boolean;
}

const props = withDefaults(defineProps<ITextEditorProps>(), {
  label: "",
  placeholder: "Escribe tu contenido aquí...",
  disabled: false,
});

const { value, errorMessage } = useField<string>(() => props.name);

const fieldValue = computed({
  get: () => value.value,
  set: (val) => {
    value.value = val;
  },
});

const uploadAndInsertImage = async (file: File) => {
  if (!getCurrentCard.value?.id) return;
  
  try {
    const response = await cardStore.createAttachment(getCurrentCard.value.id, file);
    const url = response.data.url; 

    const quill = quillEditor.value.getQuill();
    const range = quill.getSelection();
    
    // Insertamos la URL del servidor
    quill.insertEmbed(range ? range.index : 0, 'image', url);
    // Movemos el cursor al final de la imagen
    quill.setSelection(range ? range.index + 1 : 1);
  } catch (error) {
    console.error("Error al subir imagen:", error);
  }
};

// 2. Handler para el botón de la barra de herramientas
const imageHandler = () => {
  const input = document.createElement('input');
  input.setAttribute('type', 'file');
  input.setAttribute('accept', 'image/*');
  input.click();

  input.onchange = async () => {
    const file = input.files ? input.files[0] : null;
    if (file) {
      await uploadAndInsertImage(file);
    }
  };
};

// 3. Configuración de módulos con el Handler
const editorOptions = computed(() => ({
  modules: {
    toolbar: {
      container: [
        ["bold", "italic", "underline", "strike"],
        ["blockquote", "code-block"],
        [{ header: [1, 2, 3, false] }],
        [{ list: "ordered" }, { list: "bullet" }],
        ["link", "image"],
        ["clean"],
      ],
      handlers: {
        image: imageHandler // <--- Esto intercepta el clic en el botón
      }
    },
  },
  placeholder: props.placeholder,
}));

onMounted(() => {
  const quill = quillEditor.value.getQuill();
  
  // Mantenemos el listener del paste para cuando peguen recortes (Ctrl+V)
  quill.root.addEventListener('paste', (event: ClipboardEvent) => {
    const items = event.clipboardData?.items;
    if (!items) return;

    for (let i = 0; i < items.length; i++) {
      if (items[i].type.indexOf('image') !== -1) {
        const file = items[i].getAsFile();
        if (file) {
          event.preventDefault();
          uploadAndInsertImage(file);
        }
      }
    }
  }, false);
});
</script>
