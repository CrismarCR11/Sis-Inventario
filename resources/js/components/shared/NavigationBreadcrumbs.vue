<template>
  <v-breadcrumbs class="py-0" :items="breadcrumbItems" divider="/">
    <template v-slot:prepend>
      <v-icon icon="mdi-home" size="small" class="mr-1" />
    </template>
  </v-breadcrumbs>
  <h1 class="px-2 mb-3" v-if="title">{{ title }}</h1>
</template>

<script setup lang="ts">
import { computed } from "vue";
import { useRoute } from "vue-router";
import type { IBreadcrumbItem } from "@/core/types/IBreadcrumbItem";

const props = withDefaults(
  defineProps<{
    customItems?: IBreadcrumbItem[];
    title?: string;
  }>(),
  {
    customItems: undefined,
    title: "",
  },
);

const route = useRoute();

const breadcrumbItems = computed<IBreadcrumbItem[]>(() => {
  if (props.customItems) return props.customItems;

  const paths = route.path.split("/").filter(Boolean);

  const items: IBreadcrumbItem[] = [];

  paths.forEach((path, index) => {
    const to = "/" + paths.slice(0, index + 1).join("/");
    items.push({
      title: path.charAt(0).toUpperCase() + path.slice(1),
      disabled: index === paths.length - 1,
      to: to,
    });
  });

  return items;
});
</script>
