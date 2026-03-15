<template>
  <Modal 
    ref="modal"
    v-model="isOpen" 
    :title="formTitle"
    @beforeClose="close"
  >
    <v-form @submit.prevent="onSubmit">
      <v-alert
        v-if="Object.keys(errors).length"
        type="warning"
        class="mb-4"
      >
        <span class="font-weight-bold">Por favor, corrige los siguientes errores:</span>
        <ul>
          <li v-for="error in errors" :key="error">{{ error }}</li>
        </ul>
      </v-alert>
      <slot />
      
      <div class="d-flex justify-end mt-4">
        <v-btn
          color="primary"
          type="submit"
          :loading="loading"
          :disabled="loading"
          prepend-icon="mdi-content-save"
        >
          {{ loading ? 'Procediendo...' : saveButtonText }}
        </v-btn>
      </div>
    </v-form>
  </Modal>
</template>

<script setup lang="ts">
import { ref, watch, computed } from 'vue';
import { useForm } from 'vee-validate';
import Modal from "@/components/modal/Modal.vue";

const props = defineProps<{
  isOpen: boolean;
  item: any | null;
  formTitle: string;
  schema: any;
  loading: boolean;
}>();

const emit = defineEmits(['save', 'cancel']);

const isOpen = ref(props.isOpen);

const { 
  handleSubmit, 
  resetForm, 
  setErrors,
  setValues,
  setFieldValue,
  errors
} = useForm({
  validationSchema: props.schema,
  initialValues: props.item,
});

const saveButtonText = computed(() => {
  return props.item ? 'Actualizar' : 'Crear';
});

const onSubmit = handleSubmit(async (formValues) => {
  emit('save', formValues, { setErrors, resetForm });
});

defineExpose({
  setErrors,
  setValues,
  resetForm,
  setFieldValue,
});

watch(() => props.isOpen, (newVal) => {
  isOpen.value = newVal;
  if (!newVal) {
    resetForm();
  }
});

watch(() => [props.isOpen, props.item], ([newOpen, newItem]) => {
  isOpen.value = newOpen;

  if (newOpen && newItem) {
    setValues(newItem);
  }
  
  if (!newOpen || !newItem) {
    resetForm();
  }
}, { immediate: true });

const close = () => {
  emit('cancel');
};
</script>