// resources/js/primevue/pt.js

/* ─────────────────────────────
   Button (ya lo tenías; lo dejo igual)
───────────────────────────── */
export const ptButton = {
    root: ({ props }) => ({
        class: [
            'inline-flex items-center justify-center gap-2 select-none',
            'rounded-2xl px-4 py-3 text-sm font-semibold',
            'transition active:scale-[0.99]',
            'focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2',

            props?.disabled ? 'opacity-60 cursor-not-allowed' : '',

            props?.outlined
                ? 'border bg-white text-gray-900 hover:bg-gray-50'
                : 'bg-indigo-600 text-white shadow-sm hover:bg-indigo-700',
        ].join(' ')
    }),
}

/* ─────────────────────────────
Tag (material/SaaS)
───────────────────────────── */
export const ptTag = {
    root: () => ({
        class:
            'inline-flex items-center rounded-full border bg-white px-3 py-1 text-xs text-gray-700'
    }),
}

/* ─────────────────────────────
   Message
───────────────────────────── */
export const ptMessage = {
    root: ({ props }) => ({
        class: [
            'w-full rounded-2xl border px-4 py-3 text-sm',
            props?.severity === 'success'
                ? 'border-emerald-200 bg-emerald-50 text-emerald-900'
                : props?.severity === 'warn'
                    ? 'border-amber-200 bg-amber-50 text-amber-900'
                    : props?.severity === 'error'
                        ? 'border-red-200 bg-red-50 text-red-900'
                        : 'border-sky-200 bg-sky-50 text-sky-900',
        ].join(' ')
    }),
    wrapper: () => ({ class: 'flex items-start gap-3' }),
    icon: () => ({ class: 'mt-0.5 text-base' }),
    text: () => ({ class: 'w-full' }),
    closeButton: () => ({
        class:
            'ml-2 inline-flex items-center justify-center rounded-lg p-1 ' +
            'text-gray-500 hover:text-gray-800 hover:bg-white/60 transition'
    }),
    closeIcon: () => ({ class: 'text-sm' }),
}

/* ─────────────────────────────
   InputText
───────────────────────────── */
export const ptInputText = {
    root: ({ props }) => ({
        class: [
            'w-full border rounded-xl px-4 py-2.5 text-sm',
            'bg-white text-gray-900 placeholder-gray-400',
            'transition',
            'focus:outline-none focus:ring-2 focus:ring-black/10 focus:border-gray-300',
            props?.invalid ? '!border-red-300 !ring-1 !ring-red-200' : 'border-gray-200 hover:border-gray-300',
            props?.disabled ? 'bg-gray-50 opacity-60 cursor-not-allowed' : '',
        ].join(' ')
    }),
}

/* ─────────────────────────────
   Textarea
───────────────────────────── */
export const ptTextarea = {
    root: ({ props }) => ({
        class: [
            'w-full border rounded-xl px-4 py-2.5 text-sm',
            'bg-white text-gray-900 placeholder-gray-400',
            'transition',
            'focus:outline-none focus:ring-2 focus:ring-black/10 focus:border-gray-300',
            props?.invalid ? '!border-red-300 !ring-1 !ring-red-200' : 'border-gray-200 hover:border-gray-300',
            props?.disabled ? 'bg-gray-50 opacity-60 cursor-not-allowed' : '',
        ].join(' ')
    }),
}

/* ─────────────────────────────
   Select (v4) – panel material/SaaS
───────────────────────────── */
export const ptSelect = {
    root: ({ props, state }) => ({
        class: [
            'relative inline-flex items-center gap-2 w-full',
            'border rounded-xl px-4 py-2.5 text-sm',
            'bg-white text-gray-900',
            'transition',
            'focus-within:outline-none focus-within:ring-2 focus-within:ring-black/10',

            props.disabled ? 'opacity-60 bg-gray-50 cursor-not-allowed' : 'cursor-pointer hover:border-gray-300',
            props.invalid ? '!border-red-300 !ring-1 !ring-red-200' : 'border-gray-200',
            state.overlayVisible ? 'ring-2 ring-black/10' : '',
        ],
    }),

    label: ({ props }) => ({
        class: [
            'flex-1 min-w-0 truncate',
            props.modelValue === null || props.modelValue === undefined || props.modelValue === ''
                ? 'text-gray-400'
                : 'text-gray-900',
        ],
    }),

    dropdown: () => ({
        class: [
            'flex items-center justify-center',
            'w-8 h-8 -mr-2 rounded-lg',
            'text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition',
        ],
    }),

    overlay: () => ({
        class: [
            'mt-2',
            'rounded-xl border border-gray-200 bg-white shadow-lg',
            'overflow-hidden',
            'z-[60]',
        ],
    }),

    listContainer: () => ({ class: 'max-h-60 overflow-auto' }),
    list: () => ({ class: 'py-1' }),

    option: ({ context }) => ({
        class: [
            'px-3 py-2 text-sm flex items-center gap-2 select-none transition',
            context.disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer hover:bg-gray-50',
            context.selected ? 'bg-indigo-50 text-indigo-700 font-medium' : 'text-gray-700',
            context.focused && !context.disabled ? 'bg-gray-100' : '',
        ],
    }),

    optionLabel: () => ({ class: 'truncate flex-1' }),
    optionCheckIcon: () => ({ class: 'text-indigo-600 text-sm' }),
    emptyMessage: () => ({ class: 'px-3 py-2 text-sm text-gray-500' }),
    hiddenFirstFocusableEl: () => ({ class: 'hidden' }),
    hiddenLastFocusableEl: () => ({ class: 'hidden' }),
}

/* ─────────────────────────────
   Dialog (modal material/SaaS)
───────────────────────────── */
export const ptDialog = {
    mask: () => ({
        class: 'fixed inset-0 bg-black/40 backdrop-blur-[1px] flex items-center justify-center p-4 z-[80]',
    }),

    root: () => ({
        class:
            'w-full max-w-lg rounded-2xl border border-gray-200 bg-white shadow-xl overflow-hidden',
    }),

    header: () => ({
        class: 'flex items-center justify-between px-5 py-4 border-b border-gray-100',
    }),

    title: () => ({
        class: 'text-base font-semibold text-gray-900',
    }),

    headerActions: () => ({
        class: 'flex items-center gap-2',
    }),

    closeButton: () => ({
        class:
            'inline-flex items-center justify-center rounded-xl p-2 ' +
            'text-gray-500 hover:text-gray-800 hover:bg-gray-50 transition',
    }),

    closeIcon: () => ({
        class: 'text-lg leading-none',
    }),

    content: () => ({
        class: 'px-5 py-4 text-sm text-gray-700',
    }),

    footer: () => ({
        class: 'px-5 py-4 border-t border-gray-100 bg-white',
    }),
}

// ✅ AutoComplete (v4) para "skills tipo chips"
export const ptAutoComplete = {
    root: ({ props, state }) => ({
        class: [
            'w-full',
            'border rounded-xl bg-white text-gray-900',
            'transition',
            'focus-within:outline-none focus-within:ring-2 focus-within:ring-black/10',
            props?.invalid ? '!border-red-300 !ring-1 !ring-red-200' : 'border-gray-200 hover:border-gray-300',
            props?.disabled ? 'bg-gray-50 opacity-60 cursor-not-allowed' : '',
            state?.overlayVisible ? 'ring-2 ring-black/10' : '',
        ].join(' '),
    }),

    // contenedor chips + input
    inputMultiple: () => ({
        class: 'flex flex-wrap items-center gap-2 px-4 py-2.5',
    }),

    // Chip wrapper (token)
    chipItem: () => ({
        class: 'inline-flex',
    }),

    // Chip component PT (para el token)
    pcChip: {
        root: () => ({
            class:
                'inline-flex items-center gap-2 rounded-full bg-gray-100 text-gray-800 ' +
                'px-3 py-1 text-sm border border-gray-200',
        }),
        label: () => ({ class: 'leading-none' }),
        removeIcon: () => ({
            class:
                'text-gray-400 hover:text-red-500 cursor-pointer transition leading-none',
        }),
    },

    // icon del chip si lo usas
    chipIcon: () => ({
        class: 'text-gray-400',
    }),

    // input dentro del chips container
    inputChip: () => ({
        class: 'flex-1 min-w-[140px]',
    }),

    // ✅ PT del InputText interno (evita que tenga su propio borde)
    pcInputText: {
        root: () => ({
            class: [
                'w-full',
                'border-0 outline-none bg-transparent p-0 text-sm',
                'placeholder-gray-400',
                'focus:ring-0 focus:outline-none',
            ].join(' '),
            // ✅ workaround: evita submit del form al presionar Enter
            onKeydown: (e) => {
                if (e?.key === 'Enter') e.preventDefault()
            },
        }),
    },

    // Panel (overlay)
    overlay: () => ({
        class:
            'mt-2 rounded-xl border border-gray-200 bg-white shadow-lg overflow-hidden z-[60]',
    }),

    listContainer: () => ({ class: 'max-h-60 overflow-auto' }),
    list: () => ({ class: 'py-1' }),

    option: ({ context }) => ({
        class: [
            'px-3 py-2 text-sm flex items-center gap-2 select-none transition',
            context.disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer hover:bg-gray-50',
            context.selected ? 'bg-indigo-50 text-indigo-700 font-medium' : 'text-gray-700',
            context.focused && !context.disabled ? 'bg-gray-100' : '',
        ].join(' '),
    }),

    emptyMessage: () => ({ class: 'px-3 py-2 text-sm text-gray-500' }),
}