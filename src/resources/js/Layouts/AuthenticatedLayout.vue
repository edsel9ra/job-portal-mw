<template>

    <Head title="Empleo Mister Wings" />

    <div class="relative flex h-screen overflow-hidden bg-slate-100">
        <!-- Fondos decorativos -->
        <div
            class="pointer-events-none absolute left-[-180px] top-[-180px] h-96 w-96 rounded-full bg-red-600/20 blur-3xl">
        </div>
        <div
            class="pointer-events-none absolute bottom-[-220px] right-[-220px] h-[32rem] w-[32rem] rounded-full bg-blue-700/20 blur-3xl">
        </div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 flex h-screen w-72 flex-col overflow-hidden border-r border-white/10 bg-slate-950 text-white shadow-2xl shadow-black/40 transition-transform duration-300 ease-in-out lg:relative lg:translate-x-0">
            <!-- Decoración sidebar -->
            <div class="pointer-events-none absolute -right-24 top-16 h-56 w-56 rounded-full bg-red-600/20 blur-3xl">
            </div>
            <div class="pointer-events-none absolute bottom-10 left-8 h-40 w-40 rounded-full bg-blue-600/20 blur-2xl">
            </div>

            <!-- Logo -->
            <div class="relative flex h-20 flex-shrink-0 items-center border-b border-white/10 px-5">
                <Link :href="dashboardRoute" class="flex min-w-0 items-center gap-3">
                    <div
                        class="flex h-12 w-12 flex-shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-white/10 shadow-lg ring-1 ring-white/15">
                        <img src="/images/logo.png" alt="Mister Wings" class="h-9 w-9 object-contain" />
                    </div>

                    <div class="min-w-0">
                        <p class="truncate text-lg font-black uppercase tracking-wide text-white">
                            Empleo
                        </p>
                        <p class="truncate text-sm font-semibold text-slate-400">
                            Mister Wings
                        </p>
                    </div>
                </Link>
            </div>

            <!-- Perfil compacto -->
            <!--<div class="relative flex-shrink-0 border-b border-white/10 px-4 py-4">
                <div class="rounded-3xl bg-white/10 p-4 shadow-lg ring-1 ring-white/10 backdrop-blur">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-11 w-11 flex-shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-red-600 text-sm font-black text-white shadow-lg shadow-red-900/30">
                            <UserAvatar :name="userName" :photo="userPhoto" size="xs" alt="Foto de perfil" />
                        </div>

                        <div class="min-w-0">
                            <p class="truncate text-sm font-bold text-white">
                                {{ user?.name }}
                            </p>

                            <p class="mt-0.5 text-xs font-medium text-slate-300">
                                {{ user?.isReclutador ? 'Reclutador' : 'Candidato' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>-->

            <!-- Navegación -->
            <nav class="relative flex-1 overflow-y-auto px-4 py-5">
                <!--<NavSectionModern label="General" />-->

                <NavLinkModern :href="dashboardRoute" label="Dashboard" icon="home" @close="sidebarOpen = false" />

                <!-- Reclutador -->
                <template v-if="user?.isReclutador">

                    <NavLinkModern :href="route('reclutador.jobs.index')" label="Todas las ofertas" icon="list_alt"
                        @close="sidebarOpen = false" />

                    <NavLinkModern :href="route('reclutador.jobs.create')" label="Nueva oferta" icon="add_circle"
                        @close="sidebarOpen = false" />

                    <NavLinkModern :href="route('reclutador.candidates.index')" label="Candidatos" icon="groups"
                        :badge="aplicacionesNuevas > 0 ? aplicacionesNuevas : null" @close="sidebarOpen = false" />

                    <!--<NavLinkModern :href="route('jobs.index')" label="Ver portal público" icon="travel_explore"
                        @close="sidebarOpen = false" />-->
                </template>

                <!-- Candidato -->
                <template v-if="user?.isCandidato">

                    <NavLinkModern :href="curriculumHref" label="Mi currículum" icon="description"
                        @close="sidebarOpen = false" />

                    <NavLinkModern :href="profileEditHref" label="Editar perfil" icon="description"
                        @close="sidebarOpen = false" />

                    <NavLinkModern :href="route('candidato.jobs.index')" label="Ver ofertas" icon="search"
                        @close="sidebarOpen = false" />

                    <NavLinkModern :href="route('candidato.applications.index')" label="Mis aplicaciones" icon="send"
                        :badge="aplicacionesPendientes > 0 ? aplicacionesPendientes : null"
                        @close="sidebarOpen = false" />
                </template>
            </nav>

            <!-- Footer sidebar -->
            <div class="relative flex-shrink-0 border-t border-white/10 px-4 py-4">
                <NavLinkModern :href="route('profile.edit')" label="Mi cuenta" icon="settings"
                    @close="sidebarOpen = false" />

                <button type="button"
                    class="mt-2 flex w-full items-center gap-3 rounded-2xl px-3 py-3 text-sm font-bold text-slate-300 transition hover:bg-red-600/15 hover:text-red-300"
                    @click="logout">
                    <span class="flex h-8 w-9 items-center justify-center rounded-xl bg-white/10">
                        <span class="material-symbols-outlined text-[15px]">
                            logout
                        </span>
                    </span>

                    <span>Cerrar sesión</span>
                </button>
            </div>
        </aside>

        <!-- Overlay móvil -->
        <div v-if="sidebarOpen" class="fixed inset-0 z-40 bg-slate-950/70 backdrop-blur-sm lg:hidden"
            @click="sidebarOpen = false" />

        <!-- Área principal -->
        <div class="relative flex min-h-0 min-w-0 flex-1 flex-col overflow-hidden">
            <!-- Topbar -->
            <header
                class="z-30 flex h-20 flex-shrink-0 items-center gap-4 border-b border-slate-200/80 bg-white/90 px-4 shadow-sm backdrop-blur-xl sm:px-6">
                <button type="button"
                    class="flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:border-red-200 hover:bg-red-50 hover:text-red-600 lg:hidden"
                    aria-label="Abrir menú" @click="sidebarOpen = !sidebarOpen">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div class="min-w-0 flex-1">
                    <slot name="header">
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                                Panel administrativo
                            </p>
                            <h1 class="mt-1 truncate text-xl font-black text-slate-950">
                                Empleo Mister Wings
                            </h1>
                        </div>
                    </slot>
                </div>

                <!-- Usuario en topbar -->
                <div class="hidden items-center gap-3 sm:flex">
                    <div
                        class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-3 py-2 shadow-sm">
                        <div
                            class="flex h-9 w-9 items-center justify-center overflow-hidden rounded-xl bg-slate-950 text-xs font-black text-white">
                            <UserAvatar :name="userName" :photo="userPhoto" size="xs" alt="Foto de perfil" />
                        </div>

                        <div class="hidden min-w-0 md:block">
                            <p class="max-w-36 truncate text-sm font-bold text-slate-800">
                                {{ user?.name }}
                            </p>
                            <p class="text-xs font-medium text-slate-400">
                                {{ user?.isReclutador ? 'Reclutador' : 'Candidato' }}
                            </p>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Contenido -->
            <main class="flex-1 overflow-y-auto bg-slate-100">
                <slot />

                <footer class="border-t border-slate-200 py-6 text-center text-xs font-medium text-slate-400">
                    © {{ new Date().getFullYear() }} Empleo Mister Wings. Todos los derechos reservados.
                </footer>
            </main>
        </div>
    </div>
</template>

<script setup>
import { computed, defineComponent, h, ref } from 'vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import UserAvatar from '@/Components/UserAvatar.vue';

const sidebarOpen = ref(false);
const page = usePage();

const user = computed(() => page.props.auth?.user);
const userName = computed(() => page.props.auth?.user?.name ?? '');
const userPhoto = computed(() => page.props.auth?.user?.candidate?.photo ?? null);

const dashboardRoute = computed(() =>
    user.value?.isReclutador
        ? route('reclutador.dashboard')
        : route('candidato.dashboard')
);

function routeExists(name) {
    try {
        route(name);
        return true;
    } catch {
        return false;
    }
}

const hasResume = computed(() => page.props.candidate?.hasResume ?? false);
const resumeId = computed(() => page.props.candidate?.resumeId ?? null);

const curriculumHref = computed(() => {
    if (!hasResume.value) return route('candidato.resume.create');

    if (routeExists('candidato.resume.show')) {
        return route('candidato.resume.show');
    }

    if (resumeId.value && routeExists('candidato.resume.edit')) {
        return route('candidato.resume.edit', resumeId.value);
    }

    return route('candidato.resume.create');
});

const profileEditHref = computed(() => route('candidato.profile.edit'));

const aplicacionesPendientes = computed(
    () => page.props.stats?.aplicacionesPendientes ?? 0
);

const aplicacionesNuevas = computed(
    () => page.props.stats?.aplicacionesNuevas ?? 0
);

function isActive(href) {
    try {
        return page.url.startsWith(new URL(href, window.location.origin).pathname);
    } catch {
        return false;
    }
}

function logout() {
    router.post(route('logout'));
}

/**
 * Componentes locales para no depender del estilo anterior de NavItem/NavSection.
 */
const NavSectionModern = defineComponent({
    props: {
        label: {
            type: String,
            required: true,
        },
    },
    setup(props) {
        return () =>
            h(
                'p',
                {
                    class:
                        'px-3 pb-1 pt-5 text-sm font-black uppercase tracking-[0.22em] text-slate-500 first:pt-0',
                },
                props.label
            );
    },
});

const NavLinkModern = defineComponent({
    props: {
        href: {
            type: String,
            required: true,
        },
        label: {
            type: String,
            required: true,
        },
        icon: {
            type: String,
            required: true,
        },
        badge: {
            type: [Number, String, null],
            default: null,
        },
    },
    emits: ['close'],
    setup(props, { emit }) {
        return () => {
            const active = isActive(props.href);

            return h(
                Link,
                {
                    href: props.href,
                    onClick: () => emit('close'),
                    class:
                        'group mb-1 flex items-center gap-3 rounded-2xl px-3 py-3 text-sm font-bold transition ' +
                        (active
                            ? 'bg-red-600 text-white shadow-lg shadow-red-950/30'
                            : 'text-slate-300 hover:bg-white/10 hover:text-white'),
                },
                {
                    default: () => [
                        h(
                            'span',
                            {
                                class:
                                    'flex h-8 w-9 items-center justify-center rounded-sm transition ' +
                                    (active
                                        ? 'bg-white/15'
                                        : 'bg-white/10 group-hover:bg-white/15'),
                            },
                            [
                                h(
                                    'span',
                                    {
                                        class: 'material-symbols-outlined text-[20px]',
                                    },
                                    props.icon
                                ),
                            ]
                        ),

                        h(
                            'span',
                            {
                                class: 'min-w-0 flex-1 truncate',
                            },
                            props.label
                        ),

                        props.badge
                            ? h(
                                'span',
                                {
                                    class:
                                        'rounded-full bg-red-500 px-2 py-0.5 text-sm font-black text-white',
                                },
                                props.badge
                            )
                            : null,
                    ],
                }
            );
        };
    },
});
</script>

<style scoped>
.material-symbols-outlined {
    font-variation-settings: "FILL" 0, "wght" 500, "GRAD" 0, "opsz" 24;
}
</style>