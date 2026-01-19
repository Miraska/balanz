import imagemin from 'imagemin';
import imageminMozjpeg from 'imagemin-mozjpeg';
import imageminPngquant from 'imagemin-pngquant';
import imageminSvgo from 'imagemin-svgo';
import imageminGifsicle from 'imagemin-gifsicle';
import { fileURLToPath } from 'url';
import { dirname, join } from 'path';
import { readdirSync, statSync, existsSync, mkdirSync } from 'fs';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

const IMAGES_DIR = join(__dirname, 'assets', 'images');
const BACKUP_DIR = join(__dirname, 'assets', 'images-backup');

console.log('🖼️  Начинаем оптимизацию изображений...\n');

// Создаем резервную копию, если её нет
if (!existsSync(BACKUP_DIR)) {
  console.log('📁 Создаем резервную копию в assets/images-backup/...');
  // Копируем структуру будет делать imagemin
}

// Функция для получения всех поддиректорий
function getAllDirectories(dirPath, arrayOfDirs = []) {
  arrayOfDirs.push(dirPath);
  
  const files = readdirSync(dirPath);
  
  files.forEach(file => {
    const fullPath = join(dirPath, file);
    if (statSync(fullPath).isDirectory()) {
      getAllDirectories(fullPath, arrayOfDirs);
    }
  });
  
  return arrayOfDirs;
}

// Получаем все директории
const directories = getAllDirectories(IMAGES_DIR);

console.log(`📂 Найдено директорий: ${directories.length}\n`);

// Оптимизируем изображения в каждой директории
for (const dir of directories) {
  const relativePath = dir.replace(IMAGES_DIR, '').replace(/^[\\\/]/, '');
  const backupPath = relativePath ? join(BACKUP_DIR, relativePath) : BACKUP_DIR;
  
  try {
    // Создаем директорию для бэкапа
    if (!existsSync(backupPath)) {
      mkdirSync(backupPath, { recursive: true });
    }

    // Сначала копируем оригиналы в backup
    const files = await imagemin([join(dir, '*.{jpg,jpeg,png,svg,gif}')], {
      destination: backupPath,
    });

    if (files.length === 0) continue;

    console.log(`📁 ${relativePath || 'корневая папка'}`);
    console.log(`   Найдено файлов: ${files.length}`);

    // Оптимизируем и сохраняем в исходную директорию
    const optimizedFiles = await imagemin([join(dir, '*.{jpg,jpeg,png,svg,gif}')], {
      destination: dir,
      plugins: [
        // JPEG - качество 85 (очень хорошее качество с хорошим сжатием)
        imageminMozjpeg({
          quality: 85,
          progressive: true
        }),
        // PNG - качество 80-95 (почти без потери качества)
        imageminPngquant({
          quality: [0.8, 0.95],
          speed: 1, // Максимальное качество (медленнее, но лучше)
          strip: true // Удаляем метаданные
        }),
        // SVG - оптимизация без потери качества
        imageminSvgo({
          plugins: [
            {
              name: 'preset-default',
              params: {
                overrides: {
                  removeViewBox: false,
                  cleanupIds: true,
                  removeUnusedNS: true
                }
              }
            }
          ]
        }),
        // GIF - оптимизация
        imageminGifsicle({
          optimizationLevel: 3,
          interlaced: true
        })
      ]
    });

    // Подсчитываем экономию
    let originalSize = 0;
    let optimizedSize = 0;

    files.forEach(file => {
      originalSize += statSync(file.destinationPath).size;
    });

    optimizedFiles.forEach(file => {
      optimizedSize += statSync(file.destinationPath).size;
    });

    const savedBytes = originalSize - optimizedSize;
    const savedPercent = ((savedBytes / originalSize) * 100).toFixed(1);
    const savedKB = (savedBytes / 1024).toFixed(1);

    console.log(`   Сжато: ${savedKB} KB (${savedPercent}%)\n`);

  } catch (error) {
    console.error(`❌ Ошибка в ${relativePath}:`, error.message);
  }
}

console.log('\n✅ Оптимизация завершена!');
console.log('📁 Оригиналы сохранены в assets/images-backup/');
console.log('\n💡 Совет: проверьте результат визуально.');
console.log('   Если качество устраивает - можете удалить папку images-backup.\n');
