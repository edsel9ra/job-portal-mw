<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    variant: {
        type: String,
        default: 'default',
    },
});
</script>

<template>
    <!-- Layout moderno: pantalla completa, sin tarjeta pequeña -->
    <div v-if="variant === 'modern'" class="min-h-screen bg-slate-950">
        <slot />
    </div>

    <!-- Layout clásico de Laravel Breeze -->
    <div v-else class="flex min-h-screen flex-col items-center bg-gray-100 pt-6 sm:justify-center sm:pt-0">
        <div>
            <Link href="/">
                <ApplicationLogo class="h-20 w-20 fill-current text-gray-500" />
            </Link>
        </div>

        <div class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>