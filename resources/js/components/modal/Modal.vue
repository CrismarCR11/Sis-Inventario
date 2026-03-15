<template>
  <v-dialog
    v-model="internalVisible"
    transition="dialog-bottom-transition"
    persistent
    scrollable
    :max-width="maxWidth"
    class="dialog"
  >
    <v-card class="d-flex flex-column pb-4">
      <v-card-title class="bg-primary py-2 px-5 mb-4">
        <v-row align="center" class="w-100 flex-wrap" no-gutters>
          <v-col class="d-flex align-center" cols="4" md="4">
            <v-img
              :src="Logo"
              alt="Faboce S.R.L."
              class="logo-img"
              contain
            ></v-img>
          </v-col>
          <v-col cols="4" md="4" class="d-flex justify-center mt-2 mt-md-0">
            <slot name="title">
              <span
                class="white--text text-center font-weight-medium text-subtitle-1 text-md-h6"
                style="
                  max-width: 100%;
                  word-break: break-word;
                  white-space: normal;
                "
                v-html="title"
              >
              </span>
            </slot>
          </v-col>
          <v-col
            class="d-flex justify-end align-center"
            v-if="showClose"
            cols="4"
            md="4"
          >
            <v-btn icon class="white--text" @click="close">
              <v-icon>mdi-close</v-icon>
            </v-btn>
          </v-col>
        </v-row>
      </v-card-title>
      <v-card-text class="py-1">
        <slot></slot>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>

<script setup lang="ts">
import { ref, watch } from "vue";
import Logo from "@/assets/images/inventarios.png";

interface Props {
  title: string;
  modelValue: boolean;
  maxWidth?: string | number;
  showClose?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
  maxWidth: "900px",
  showClose: true,
});

const emit = defineEmits(["update:modelValue", "beforeClose"]);
const internalVisible = ref(props.modelValue);

watch(
  () => props.modelValue,
  (val) => {
    internalVisible.value = val;
  },
);
watch(internalVisible, (val) => {
  emit("update:modelValue", val);
});

const open = () => {
  internalVisible.value = true;
};

const close = () => {
  internalVisible.value = false;
  emit("beforeClose");
};

defineExpose({
  open,
  close,
});
</script>

<style scoped>
.dialog {
  max-height: 100%;
}
.logo-img {
  max-width: 80px;
}

@media (min-width: 600px) {
  .logo-img {
    max-width: 80px;
  }
}

@media (min-width: 960px) {
  .logo-img {
    max-width: 80px;
  }
}
</style>
