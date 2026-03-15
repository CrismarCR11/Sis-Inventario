<template>
  <FormProviderWrapper
    ref="formWrapper"
    :key="isEditMode ? item?.id : 'create'"
    :is-open="isOpen"
    :item="item"
    :form-title="formTitle"
    :schema="CompanySchema"
    :loading="isLoading"
    @cancel="() => emit('cancel')"
    @save="handleFormSave"
  >
    <FormInput
      name="ruc"
      label="RUC"
      type="text"
      placeholder="Ingrese RUC (11 dígitos)"
      icon="mdi-card-account-details"
      :disabled="isEditMode"
    />
    
    <FormInput
      name="razon_social"
      label="Razón Social"
      type="text"
      placeholder="Ingrese la razón social"
      icon="mdi-domain"
    />
    
    <FormInput
      name="nombre_comercial"
      label="Nombre Comercial"
      type="text"
      placeholder="Ingrese el nombre comercial (opcional)"
      icon="mdi-store"
    />
    
    <FormInput
      name="email"
      label="Email"
      type="email"
      placeholder="Ingrese el email"
      icon="mdi-email"
    />
    
    <FormInput
      name="telefono"
      label="Teléfono"
      type="text"
      placeholder="Ingrese el teléfono"
      icon="mdi-phone"
    />
    
    <FormTextArea
      name="direccion"
      label="Dirección"
      placeholder="Ingrese la dirección"
      icon="mdi-map-marker"
      :rows="2"
    />
  </FormProviderWrapper>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import { FormInput, FormTextArea } from '@/components/form';
import FormProviderWrapper from "@/components/form/FormProviderWrapper.vue";
import { useCompanyStore } from '@/stores/companyStore';
import { createCompanySchema, editCompanySchema } from './validacion'; 
import { noty } from '@/core/utils/Noty';
import type { Company, CompanyFormData } from '@/services/companyService';

const props = defineProps<{
  isOpen: boolean;
  item: Company | null;
  isLoading: boolean;
}>();

const emit = defineEmits(['cancel', 'save']);

const companyStore = useCompanyStore();
const formWrapper = ref<InstanceType<typeof FormProviderWrapper> | null>(null);

const isEditMode = computed(() => !!props.item?.id);
const formTitle = computed(() => (isEditMode.value ? 'Editar Empresa' : 'Nueva Empresa'));

const CompanySchema = computed(() => {
  return isEditMode.value ? editCompanySchema : createCompanySchema;
});

const handleFormSave = async (values: CompanyFormData, { setErrors, resetForm }: any) => {
  try {
    if (isEditMode.value && props.item?.id) {
      await companyStore.updateCompany(props.item.id, values);
    } else {
      await companyStore.createCompany(values);
    }
    
    resetForm();
    noty.success("Empresa guardada exitosamente");
    emit('save');
  } catch (error: any) {
    if (error.response?.data?.errors) {
      setErrors(error.response.data.errors);
    } else {
      setErrors({ general: error.response?.data?.message || 'Error al guardar' });
    }
  }
};
</script>