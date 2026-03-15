<template>
  <v-form @submit.prevent="handleSubmit" autocomplete="off">
    <v-row justify="center" class="pa-0 ma-0">
      <slot></slot>
      <v-col cols="12" class="text-center py-1">
        <v-btn
          color="modalheader"
          variant="outlined"
          class="rounded-pill"
          prepend-icon="mdi-check"
          type="submit"
        >
          {{ submitText }}
        </v-btn>
      </v-col>
    </v-row>
  </v-form>
</template>

<script setup lang="ts">
import { useForm } from "vee-validate";
import { noty } from "@/core/utils/Noty";

const props = defineProps({
  validationSchema: {
    type: Object,
    required: true
  },
  submitText: {
    type: String,
    default: "Guardar"
  },
  initialValues: {
    type: Object,
    default: () => ({})
  }
});

const emit = defineEmits(["submit"]);

const { handleSubmit: veeHandleSubmit, setFieldError, setValues, resetForm } = useForm({
  validationSchema: props.validationSchema,
  initialValues: props.initialValues
});

const handleSubmit = veeHandleSubmit(async (values) => {
  try {
    emit("submit", values);
  } catch (err: any) {
    if (err.inner) {
      err.inner.forEach((e: any) => {
        noty.error(e.path);
      });
    } else {
      noty.error("Error desconocido:");
    }
  }
});

defineExpose({
  setValues,
  resetForm,
  setFieldError
});
</script>