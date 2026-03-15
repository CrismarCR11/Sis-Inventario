<template>
  <FormSkeletonButton v-if="loading" :label="label" />
  <v-btn
    v-else
    :color="color"
    variant="outlined"
    class="rounded-pill text-capitalize font-weight-medium"
    prepend-icon="mdi-check"
    type="submit"
    :block="isMobile"
  >
    {{ label }}
  </v-btn>
</template>

<script setup lang="ts">
import { computed } from "vue";
import { useDisplay } from "vuetify";
import FormSkeletonButton from "../skeleton/FormSkeletonButton.vue";

defineProps<{
  label: string;
  color?: string;
  loading?: boolean
}>();

const { mdAndDown } = useDisplay();
const isMobile = computed(() => mdAndDown.value);
</script>

<style scoped>
.v-btn {
  min-width: 180px;
}
</style>
