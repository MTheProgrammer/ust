<?php
namespace Strix\StationaryShop\Console\Command;

use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Magento\Framework\Registry;
use Strix\StationaryShop\Model\ResourceModel\Collection\StationaryShopCollectionFactory;
use Strix\StationaryShop\Model\StationaryShop;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    /**
     * @var State
     */
    private $appState;

    /**
     * @var Registry
     */
    private $registry;

    /**
     * @var StationaryShopCollectionFactory
     */
    private $collectionFactory;


    /**
     * @param State $appState
     * @param Registry $registry
     * @param StationaryShopCollectionFactory $collectionFactory
     * @param null $name
     */
    public function __construct(
        State $appState,
        Registry $registry,
        StationaryShopCollectionFactory $collectionFactory,
        $name = null
    ) {
        $this->appState = $appState;
        $this->registry = $registry;
        parent::__construct($name);
        $this->collectionFactory = $collectionFactory;
    }

    /**
     *
     */
    protected function configure()
    {
        $this->setName('agh:test')
            ->setDescription('');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->appState->setAreaCode(Area::AREA_ADMINHTML);
        $this->registry->register('isSecureArea', true);

        $collection = $this->collectionFactory->create()
            // Filtering collection
            ->addFieldToFilter('code', ['like' => '%q%']);

        /**
         * @var StationaryShop $item
         */
        foreach ($collection as $item) {
            $output->writeln($item->getName());
            // $output->writeln(json_encode($item->getData(), JSON_PRETTY_PRINT));
        }
        $output->writeln($collection->getSelect()->__toString());
    }
}