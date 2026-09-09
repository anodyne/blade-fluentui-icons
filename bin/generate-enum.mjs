#!/usr/bin/env bun

import fs from 'node:fs/promises';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const projectRoot = path.resolve(path.dirname(fileURLToPath(import.meta.url)), '..');
const iconDirectory = path.resolve(projectRoot, process.argv[2] ?? 'resources/svg');
const enumFile = path.resolve(projectRoot, process.argv[3] ?? 'src/FluentUI.php');

async function generateEnum() {
    const icons = (await fs.readdir(iconDirectory, { withFileTypes: true }))
        .filter((entry) => entry.isFile() && entry.name.endsWith('.svg'))
        .map((entry) => entry.name.slice(0, -4))
        .sort();

    if (icons.length === 0) {
        throw new Error(`No SVG icons found in ${iconDirectory}`);
    }

    const cases = new Map();

    for (const icon of icons) {
        if (!/^[fo]-[a-z0-9]+(?:-[a-z0-9]+)*$/.test(icon)) {
            throw new Error(`Unexpected icon name: ${icon}`);
        }

        let caseName = icon.slice(2).split('-')
            .map((segment) => segment.charAt(0).toUpperCase() + segment.slice(1))
            .join('');

        if (icon.startsWith('f-')) {
            caseName += 'Filled';
        }

        if (/^[0-9]/.test(caseName) || caseName.toLowerCase() === 'class') {
            caseName = `Icon${caseName}`;
        }

        if (cases.has(caseName)) {
            throw new Error(`Enum case collision: ${cases.get(caseName)} and ${icon} produce ${caseName}`);
        }

        cases.set(caseName, icon);
    }

    const contents = [
        '<?php',
        '',
        'declare(strict_types=1);',
        '',
        'namespace Anodyne\\FluentUiIcons;',
        '',
        'enum FluentUI: string',
        '{',
        ...Array.from(cases, ([name, icon]) => `    case ${name} = 'fluent-${icon}';`),
        '}',
        '',
    ].join('\n');

    await fs.mkdir(path.dirname(enumFile), { recursive: true });
    await fs.writeFile(enumFile, contents);
    console.log(`Generated ${cases.size} enum cases in ${enumFile}`);
}

generateEnum().catch((error) => {
    console.error(error.message);
    process.exitCode = 1;
});
